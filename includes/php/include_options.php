<?php
$m_erreur = 'Vous n\'êtes pas connecté ME. ou M. Inscrivez-vous <a href="inscription.php">ici</a>.';
$value = '';

$afficher_formulaire = false;

if(isset($_SESSION['pseudo']))
{
    $m_erreur = '';
    $afficher_formulaire = true;
}

if(isset($_POST['btsubmit']) and isset($_SESSION['pseudo']))
{
    $query = 'SELECT photo,mdp FROM membres WHERE pseudo = (?)';
    $stmt = $pdo->prepare($query); 
    $stmt->execute([$_SESSION['pseudo']]);
    $donnees = $stmt->fetch();

    $hash_mdp = $donnees['mdp'];
    $lien_avatar = $donnees['photo'];
    $bdd_pseudo = $_SESSION['pseudo'];

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
            if(password_verify($_POST['mot_de_passe'], $hash_mdp))
            {
                if($_POST['n_mot_de_passe'] === $_POST['c_n_mot_de_passe'])
                {
                    if(mb_strlen($_POST['n_mot_de_passe']) >= 3 AND mb_strlen($_POST['n_mot_de_passe']) <= 20)
                    {
                        $hash_mdp = password_hash($_POST['n_mot_de_passe'], PASSWORD_DEFAULT);
                    }
                    else
                    {
                        $m_erreur = 'Le mot de passe doit faire entre 3 et 20 caractères.<br />';
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
            $image_conf = check_avatar();

            if($image_conf)
            {
                $bdd_lien_image = '';

                if(isset($_FILES['avatar']['tmp_name']))
                {
                    if(is_uploaded_file($_FILES['avatar']['tmp_name']))
                    {
                        $lien_avatar = "avatars/" . ChangeNameFile($_FILES['avatar']['name'], $bdd_pseudo);
                        move_uploaded_file($_FILES['avatar']['tmp_name'], $lien_avatar);
                    }
                }

                $QUERY = 'UPDATE membres SET mdp = ? , photo = ? WHERE pseudo = "' . $_SESSION['pseudo'] . '"';
                $stmt = $pdo->prepare($QUERY);
                $stmt->execute([$hash_mdp, $lien_avatar]);
            }
            else
            {
                $m_erreur .= 'Le nouvel avatar que vous voulez envoyer n`\'est pas au norme (maximum 600*600, fichier image). Il restera inchangé.';
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
}
?>