<?php
$m_erreur = '';
$pseudo = '';
$afficher_formulaire = true;

if(isset($_SESSION['pseudo']))
{
    $m_erreur = 'Vous êtes déjà connecté ME. ou M. ' . $_SESSION['pseudo'] . ' !!!';
    $afficher_formulaire = false;
}
else
{
    if(isset($_POST['btsubmit']))
    {
        if(isset($_POST['pseudo']) and isset($_POST['mot_de_passe']))
        {
            if(mb_strlen($_POST['pseudo']) >= 3 AND mb_strlen($_POST['pseudo']) <= 20)
            {
                $QUERY = 'SELECT id, mdp, photo FROM membres WHERE pseudo = ?';
                $stmt = $pdo->prepare($QUERY);
                $stmt->execute([$_POST['pseudo']]);
                $nb_pseudos = $stmt->rowCount();

                if($nb_pseudos == 1)
                {
                    $data_membre = $stmt->fetch();
                    $hash_mdp = $data_membre['mdp'];
                    $lien_photo = $data_membre['photo'];
                    $id_membre = $data_membre['id'];

                    if(password_verify($_POST['mot_de_passe'], $hash_mdp))
                    {
                        $_SESSION['pseudo'] = $_POST['pseudo'];
                        $_SESSION['id'] = $id_membre;
                        $_SESSION['mot_de_passe'] = $hash_mdp;
                        $_SESSION['photo'] = $lien_photo;
                        header('Location: index.php?reussi=connecte');
                    }
                    else
                    {
                        $m_erreur = 'Le mot de passe est incorrect.';
                    }
                }
                else
                {
                    $m_erreur = 'Le pseudo n\'existe pas.';
                }

                $pseudo = $_POST['pseudo'];
            }
            else
            {
                $m_erreur = 'Vous n\'avez pas spécifié votre pseudo ou votre mot de passe.';
            }

        }
        else
        {
            echo 'Vous n\'avez pas spécifié le pseudo.';
        }
    }
}
?>