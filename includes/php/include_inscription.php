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
            if(mb_strlen($_POST['pseudo']) >= MIN_L_PSEUDO AND mb_strlen($_POST['pseudo']) <= MAX_L_PSEUDO)
            {
                $query_is_pseudo_exists = 'SELECT id FROM membres WHERE pseudo = ?';
                $stmt = $pdo->prepare($query_is_pseudo_exists);
                $stmt->execute([$_POST['pseudo']]);
                $number_accounts = $stmt->rowCount();

                if($number_accounts == 0)
                {
                    if(ctype_alnum($_POST['pseudo']))
                    {
                        if(mb_strlen($_POST['mot_de_passe']) >= MIN_L_MDP AND mb_strlen($_POST['mot_de_passe']) <= MAX_L_MDP)
                        {
                            if($_POST['c_mot_de_passe'] === $_POST['mot_de_passe'])
                            {
                               $image_conf = check_avatar();

                                if($image_conf)
                                {
                                    $member_pseudo = $_POST['pseudo'];
                                    $member_password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
                                    $member_avatar_link = '';

                                    if(!empty($_FILES['avatar']['tmp_name']))
                                    {
                                        if(is_uploaded_file($_FILES['avatar']['tmp_name']))
                                        {
                                            $member_avatar_link = 'avatars/' . ChangeNameFile($_FILES['avatar']['name'], $member_pseudo);
                                            move_uploaded_file($_FILES['avatar']['tmp_name'], $member_avatar_link);
                                        }
                                    }

                                    $query_is_pseudo_exists = 'INSERT INTO membres (id,pseudo,mdp,photo,role) VALUES (?,?,?,?,?);';
                                    $stmt = $pdo->prepare($query_is_pseudo_exists);
                                    $stmt->execute(['', $member_pseudo, $member_password, $member_avatar_link, IS_A_MEMBER]);

                                    header('Location: index.php?reussi=reussi');
                                    
                                }
                                else
                                {
                                    $m_erreur = 'Le fichier que vous avez envoyé doit faire moins de 600*600 pixels et peser moins de 5Mo.';
                                }
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

        $pseudo = htmlentities($_POST['pseudo']);
        $avatar = htmlentities($_POST['avatar']);
    }
}
?>