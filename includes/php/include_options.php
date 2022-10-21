<?php
$m_erreur = 'Vous n\'êtes pas connecté ME. ou M. Inscrivez-vous <a href="inscription.php">ici</a>.';
$value = '';

$afficher_formulaire = false;

if(isset($_SESSION['id']))
{
    $m_erreur = '';
    $afficher_formulaire = true;
}

if(isset($_POST['btsubmit']) and isset($_SESSION['id']))
{
    $query = 'SELECT photo,mdp, pseudo FROM membres WHERE id = (?)';
    $stmt = $pdo->prepare($query); 
    $stmt->execute([$_SESSION['id']]);
    $donnees = $stmt->fetch();

    $bdd_hash_mdp = $donnees['mdp'];
    $bdd_avatar = $donnees['photo'];
    $bdd_id = $_SESSION['id'];
    $bdd_pseudo = $donnees['pseudo'];

    if(
        (
            isset($_POST['mot_de_passe']) 
            and isset($_POST['n_mot_de_passe'])
            and isset($_POST['c_n_mot_de_passe'])
        )
        or
        isset($_POST['avatar'])
    )
    {
        if
        (
            !empty($_POST['mot_de_passe']) 
            and !empty($_POST['n_mot_de_passe'])
            and !empty($_POST['c_n_mot_de_passe'])
        )
        {
            if(password_verify($_POST['mot_de_passe'], $bdd_hash_mdp))
            {
                if($_POST['n_mot_de_passe'] === $_POST['c_n_mot_de_passe'])
                {
                    if(mb_strlen($_POST['n_mot_de_passe']) >= MIN_L_MDP AND mb_strlen($_POST['n_mot_de_passe']) <= MAX_L_MDP)
                    {
                        $bdd_hash_mdp = password_hash($_POST['n_mot_de_passe'], PASSWORD_DEFAULT);
                        $m_erreur = 'Le mot de passe a bien été modifié';
                    }
                    else
                    {
                        $m_erreur = 'Le mot de passe doit faire entre ' . MIN_L_MDP . ' et ' . MAX_L_MDP . ' caractères.<br />';
                    }
                }
                else
                {
                    $m_erreur = 'Le nouveau mot de passe et sa confirmation ne correspondent pas.<br />';
                }
            }
            else
            {
                $m_erreur = 'Le mot de passe enré n\'est pas correct.<br />';
            }
        }
        
        if(isset($_FILES['avatar']))
        {
			if(!empty(trim($_FILES["avatar"]["tmp_name"])))
			{
				$image_conf = check_avatar();

				if($image_conf)
				{
					$bdd_lien_image = '';

					if(isset($_FILES['avatar']['tmp_name']))
					{
						if(!empty($_FILES['avatar']['name']))
						{
							$bdd_avatar = "avatars/" . ChangeNameFile($_FILES['avatar']['name'], $bdd_pseudo);
                            
                            move_uploaded_file($_FILES['avatar']['tmp_name'], $bdd_avatar);
                        }
					}
                
					$m_erreur .= 'Le nouvel avatar a bien été envoyé sur le serveur.<br />';
				}
				else
				{
					$m_erreur .= 'Le nouvel avatar que vous voulez envoyer n`\'est pas au norme (maximum 600*600, fichier image). Il restera inchangé.';
				}
			}
        }
        else
        {
            $m_erreur .= 'Vous n\'avez pas spécifié de lien pour votre avatar. Il restera inchangé.';
        }

    }
    else
    {
        $m_erreur = 'Le formulaire n\'est pas bien rempli.';
    }

    $QUERY = 'UPDATE membres SET mdp = ? , photo = ? WHERE id = ?';
    $stmt = $pdo->prepare($QUERY); 
    $stmt->execute([$bdd_hash_mdp, $bdd_avatar, $bdd_id]);

}
?>