<?php
$error_message = '';
$pseudo = '';
$show_form = true;

# CREATE FUNCTIONS FOR CONNEXION !

if(isset($_SESSION['pseudo']))
{
    $error_message = 'Vous êtes déjà connecté ME. ou M. ' . $_SESSION['pseudo'] . ' !!!';
    $show_form = false;
}
else
{
    if(isset($_POST['btsubmit']))
    {
        if(isset($_POST['pseudo']) and isset($_POST['mot_de_passe']))
        {
            if(mb_strlen($_POST['pseudo']) >= MIN_L_PSEUDO AND mb_strlen($_POST['pseudo']) <= MAX_L_PSEUDO)
            {
                $QUERY = 'SELECT id, mdp, photo, role FROM membres WHERE pseudo = ?';
                $statement = $pdo->prepare($QUERY);
                $statement->execute([$_POST['pseudo']]);
                $nb_pseudos = $statement->rowCount();

                if($nb_pseudos === 1)
                {
                    $data_membre = $statement->fetch();
                    $hash_mdp = $data_membre['mdp'];
                    $lien_photo = $data_membre['photo'];
                    $id_membre = $data_membre['id'];
                    $role_user = $data_membre['role'];

                    if(password_verify($_POST['mot_de_passe'], $hash_mdp))
                    {
                        $_SESSION['pseudo'] = $_POST['pseudo'];
                        $_SESSION['id'] = $id_membre;
                        $_SESSION['mot_de_passe'] = $hash_mdp;
                        $_SESSION['photo'] = $lien_photo;
                        $_SESSION['role'] = $role_user;
                        header('Location: index.php?reussi=connecte');
                    }
                    else
                    {
                        $error_message = 'Le mot de passe est incorrect.';
                    }
                }
                else
                {
                    $error_message = 'Le pseudo n\'existe pas.';
                }

                $pseudo = $_POST['pseudo'];
            }
            else
            {
                $error_message = 'Vous n\'avez pas spécifié votre pseudo ou votre mot de passe.';
            }

        }
        else
        {
            $error_message = 'Vous n\'avez pas spécifié le pseudo.';
        }
    }
}
?>