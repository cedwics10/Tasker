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
                                $image_non_conf = ((!$taille_image) or
                                $_FILES["fileToUpload"]["size"] > 5 * (10 ** 6)
                                or getimagesize($filename)[0] 
                                or getimagesize($filename)[1] 
                                ) ? false : true;

                                if(!isset($_FILES["avatar"]["tmp_name"]) or $image_non_conf)
                                {
                                    $bdd_pseudo = $_POST['pseudo'];
                                    $bdd_mdp = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

                                    $QUERY = 'INSERT INTO membres (id,pseudo,mdp) VALUES (?,?,?);';
                                    $stmt = $pdo->prepare($QUERY);
                                    $stmt->execute(['', $bdd_pseudo, $bdd_mdp]); // check if bcrypt is stored correctly
                                    
                                    print_r($_FILES);
                                    exit();
                                    header('Location: index.php?reussi=reussi');
                                    exit(); 
                                    
                                }
                                else
                                {
                                    $m_erreur = 'Le fichier que vous avez envoyé n\'est pas une image ou n\'est pas conforme aux normes.';
                                   
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