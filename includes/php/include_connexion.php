<?php
$error_message = '';
$pseudo = '';
$show_form = true;

function connexion_form_is_empty()
{
    return !isset($_POST['pseudo']) or !isset($_POST['mot_de_passe']);
}

function pseudo_length_is_not_ok()
{
    if(mb_strlen($_POST['pseudo']) < MIN_L_PSEUDO 
    or mb_strlen($_POST['pseudo']) >= MAX_L_PSEUDO)
        return true;
    return false;
}

function password_length_is_not_ok()
{
    return (mb_strlen($_POST['mot_de_passe']) < MIN_L_PASSWORD 
    or mb_strlen($_POST['mot_de_passe']) >= MAX_L_PASSWORD) ? true : false;
}

function is_incorrect_password($actual_hash, $password)
{
    return !password_verify($password, $actual_hash);   
}


function pseudo_not_exists($pdo, $pseudo)
{
    $QUERY = 'SELECT id FROM membres WHERE pseudo = ?';
    $statement = $pdo->prepare($QUERY);
    $statement->execute([$pseudo]);
    $number_double = $statement->rowCount();
    if($number_double == 0)
        return true;
    return false;
}

function get_hash_of($pdo, $pseudo)
{
    $QUERY = 'SELECT mdp FROM membres WHERE pseudo = ?';
    $statement = $pdo->prepare($QUERY);
    $statement->execute([$pseudo]);
    return $statement->fetchColumn();
}

function update_session_data($pdo) 
{
    $QUERY = 'SELECT id, pseudo, photo FROM membres WHERE pseudo = ?';
    $statement = $pdo->prepare($QUERY);
    $statement->execute([$_POST['pseudo']]);
    $data_member = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION = array_replace($_SESSION, $data_member);
}

function check_connexion_form($pdo)
{
    if(connexion_form_is_empty())
        return 'Vous n\'avez pas spécifié le pseudo ou le mot de passe.';
    if(pseudo_length_is_not_ok())
        return 'Votre pseudo doit faire entre ' . MIN_L_PSEUDO. ' et ' . MAX_L_PSEUDO . ' caractères.';
    if(password_length_is_not_ok())
        return 'Votre mot de passe doit faire entre ' . MIN_L_PASSWORD. ' et ' . MAX_L_PASSWORD . ' caractères.';
    if(pseudo_not_exists($pdo, $_POST['pseudo']))
        return 'Le pseudo n\'existe pas.'; 
    $hash_mdp = get_hash_of($pdo, $_POST['pseudo']);
    if(is_incorrect_password($hash_mdp, $_POST['mot_de_passe']))
       return 'Le mot de passe est incorrect.';
    return false;
}

if(isset($_SESSION['pseudo']))
{
    $error_message = 'Vous êtes déjà connecté ME. ou M. ' . $_SESSION['pseudo'] . ' !!!';
    $show_form = false;
}
else
{
    if(isset($_POST['btsubmit']))
    {
        $error_message = check_connexion_form($pdo);
        if($error_message === false)
        {
            update_session_data($pdo);
            header('Location: ' . SUCCESSFUL_LOGIN_PAGE);
        }
    }
}
?>