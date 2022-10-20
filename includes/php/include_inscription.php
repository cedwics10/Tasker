<?php
$pseudo = '';
$m_erreur = '';
$value = '';

$afficher_formulaire = true;

if(isset($_SESSION['pseudo'])) // Déjà connecté !!
{
    $m_erreur = 'Vous êtes déjà connecté ME. ou M. ' . $_SESSION['pseudo'] . ' !!!';
    $afficher_formulaire = false;
}
else
{
    if(isset($_POST['btsubmit']))
    {
        if(isset($_POST['pseudo']) and isset($_POST['mot_de_passe']) and isset($_POST['c_mot_de_passe']))
        {
            if(mb_strlen($_POST['pseudo']) >= 3 AND mb_strlen($_POST['pseudo']) <= 20)
            {
                $QUERY = 'SELECT * FROM membres WHERE pseudo = ?';
                $stmt = $pdo->prepare($QUERY);
                $stmt->execute([$_POST['pseudo']]);
                $nb_pseudos = $stmt->rowCount();

                if($nb_pseudos == 0)
                {
                    if(ctype_alnum($_POST['pseudo']))
                    {
                        if(mb_strlen($_POST['mot_de_passe']) >= 8 AND mb_strlen($_POST['mot_de_passe']) <= 20)
                        {
                            if($_POST['c_mot_de_passe'] === $_POST['mot_de_passe'])
                            {
                                $taille_image = getimagesize($_FILES["avatar"]["tmp_name"]);
                                $image_conf = (!$taille_image or
                                    (
                                        $_FILES["avatar"]["size"] < 5 * (10 ** 6)
                                        and (getimagesize($_FILES["avatar"]['tmp_name'])[0] <= 600)
                                        and (getimagesize($_FILES["avatar"]['tmp_name'])[1] <= 600)
                                        aNd in_array(getExtension($_FILES['avatar']['tmp_name']), AVATAR_EXT_OK)
                                    )
                                ) ? 'true' : 'false';

                                if($image_conf)
                                {
                                    $bdd_pseudo = $_POST['pseudo'];
                                    $bdd_mdp = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
                                    $bdd_lien_image = '';

                                    if(isset($_FILES['avatar']['tmp_name']))
                                    {
                                        if(is_uploaded_file($_FILES['avatar']['tmp_name']))
                                        {
                                            $bdd_lien_image = "avatars/" . ChangeNameFile($_FILES['avatar']['name'], $bdd_pseudo);
                                            move_uploaded_file($_FILES['avatar']['tmp_name'], $bdd_lien_image);
                                        }
                                    }

                                    $QUERY = 'INSERT INTO membres (id,pseudo,mdp,photo) VALUES (?,?,?,?);';
                                    $stmt = $pdo->prepare($QUERY);
                                    $stmt->execute(['', $bdd_pseudo, $bdd_mdp, $bdd_lien_image]);

                                    header('Location: index.php?reussi=reussi');
                                    
                                }
                                else
                                {
                                    $m_erreur = 'Le fichier que vous avez envoyé doit faire moins de 600*600 pixels et peser moins de 5Mo.';
                                }

                                $avatar =  $_POST['avatar'];
                                print_r($_FILES);
                            }
                            else
                            {
                                $m_erreur = 'Le mot de passe et la confirmation ne correspondent pas.';
                            }
                        }
                        else
                        {
                            $m_erreur = 'Votre mot de passe doit faire entre 8 et 20 caractères.';
                        }
                    }
                    else
                    {
                        $m_erreur = 'Votre pseudo contient des caractères non-alphanumériques.';
                    }
                }
                else
                {
                    $m_erreur = 'Votre pseudo existé déjà dans la base de données.';
                }
            }
            else
            {
                $m_erreur = 'Votre pseudo doit faire entre 3 et 20 caractères.';
            }
        }
        else
        {
            $m_erreur = 'Vous n\'avez pas spécifié votre pseudo ou votre mot de passe.';
        }
        $pseudo = $_POST['pseudo'];
        $mot_de_passe = $_POST['mot_de_passe'];
    }
}
?>