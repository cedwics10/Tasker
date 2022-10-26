<?php
$error_message = 'Vous n\'êtes pas connecté ME. ou M. Inscrivez-vous <a href="inscription.php">ici</a>.';
$value = '';

$show_form = false;

if(isset($_SESSION['id']))
{
    $error_message = '';
    $show_form = true;
}

if(isset($_POST['btsubmit']) and isset($_SESSION['id']))
{
    $select_member_data = 'SELECT photo,mdp, pseudo FROM membres WHERE id = (?)';
    $statement = $pdo->prepare($select_member_data); 
    $statement->execute([$_SESSION['id']]);
    $donnees_membre = $statement->fetch();

    $member_hash_mdp = $donnees_membre['mdp'];
    $member_avatar = $donnees_membre['photo'];
    $member_id = $_SESSION['id'];
    $member_pseudo = $donnees_membre['pseudo'];

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
            if(password_verify($_POST['mot_de_passe'], $member_hash_mdp))
            {
                if($_POST['n_mot_de_passe'] === $_POST['c_n_mot_de_passe'])
                {
                    if(mb_strlen($_POST['n_mot_de_passe']) >= MIN_L_MDP AND mb_strlen($_POST['n_mot_de_passe']) <= MAX_L_MDP)
                    {
                        $member_hash_mdp = password_hash($_POST['n_mot_de_passe'], PASSWORD_DEFAULT);
                        $error_message = 'Le mot de passe a bien été modifié';
                    }
                    else
                    {
                        $error_message = 'Le mot de passe doit faire entre ' . MIN_L_MDP . ' et ' . MAX_L_MDP . ' caractères.<br />';
                    }
                }
                else
                {
                    $error_message = 'Le nouveau mot de passe et sa confirmation ne correspondent pas.<br />';
                }
            }
            else
            {
                $error_message = 'Le mot de passe enré n\'est pas correct.<br />';
            }
        }
        
        if(isset($_FILES['avatar']))
        {
			if(!empty(trim($_FILES["avatar"]["tmp_name"])))
			{
				$is_image_ok = check_uploaded_avatar();

				if($is_image_ok)
				{

					if(isset($_FILES['avatar']['tmp_name']))
					{
						if(!empty($_FILES['avatar']['name']))
						{
							$member_avatar = "avatars/" . change_base_name($_FILES['avatar']['name'], $member_pseudo);
                            move_uploaded_file($_FILES['avatar']['tmp_name'], $member_avatar);
                        }
					}
                
					$error_message .= 'Le nouvel avatar a bien été envoyé sur le serveur.<br />';
				}
				else
				{
					$error_message .= 'Le nouvel avatar que vous voulez envoyer n`\'est pas au norme (maximum 600*600, fichier image). Il restera inchangé.';
				}
			}
        }
        else
        {
            $error_message .= 'Vous n\'avez pas spécifié de lien pour votre avatar. Il restera inchangé.';
        }

    }
    else
    {
        $error_message = 'Le formulaire n\'est pas bien rempli.';
    }

    $update_member = 'UPDATE membres SET mdp = ? , photo = ? WHERE id = ?';
    $statement = $pdo->prepare($update_member); 
    $statement->execute([$member_hash_mdp, $member_avatar, $member_id]);

}
?>