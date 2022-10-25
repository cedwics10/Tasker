<?php
$pseudo = '';
$error_message = '';
$value = '';

$show_form = true;

if(isset($_SESSION['pseudo'])) // Déjà connecté !!
{
    $error_message = 'Vous êtes déjà connecté ME. ou M. ' . $_SESSION['pseudo'] . ' !!!';
    $show_form = false;
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
                               $avatar_is_ok = check_uploaded_avatar();

                                if($avatar_is_ok)
                                {
                                    $member_pseudo = $_POST['pseudo'];
                                    $member_password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
                                    $member_avatar_link = '';

                                    if(!empty($_FILES['avatar']['tmp_name']))
                                    {
                                        if(is_uploaded_file($_FILES['avatar']['tmp_name']))
                                        {
                                            $member_avatar_link = 'avatars/' . ChangeBaseName($_FILES['avatar']['name'], $member_pseudo);
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
                                    $error_message = 'Le fichier que vous avez envoyé doit faire moins de 600*600 pixels et peser moins de 5Mo.';
                                }
                            }
                            else
                            {
                                $error_message = 'Le mot de passe et la confirmation ne correspondent pas.';
                            }
                        }
                        else
                        {
                            $error_message = 'Votre mot de passe doit faire entre 8 et 20 caractères.';
                        }
                    }
                    else
                    {
                        $error_message = 'Votre pseudo contient des caractères non-alphanumériques.';
                    }
                }
                else
                {
                    $error_message = 'Votre pseudo existé déjà dans la base de données.';
                }
            }
            else
            {
                $error_message = 'Votre pseudo doit faire entre 3 et 20 caractères.';
            }
        }
        else
        {
            $error_message = 'Vous n\'avez pas spécifié votre pseudo ou votre mot de passe.';
        }

        $pseudo = htmlentities($_POST['pseudo']);
        if(!empty($_FILES['avatar']['tmp_name'])) 
        {
            $avatar = htmlentities($_FILES['avatar']['tmp_name']);
        }
    }
}
?>