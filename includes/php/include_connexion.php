<?php
$error_message = '';
$pseudo = '';
$show_form = true;

function is_pseudo_length_not_ok()
{
    if(mb_strlen($_POST['pseudo']) < MIN_L_PSEUDO 
    AND mb_strlen($_POST['pseudo']) >= MAX_L_PSEUDO)
        return true;
    return false;
}

function is_password_length_not_ok()
{
    if(mb_strlen($_POST['mot_de_passe']) < MIN_L_PASSWORD 
    AND mb_strlen($_POST['pseudo']) >= MAX_L_PASSWORD)
        return true;
    return false;
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

function update_session_data() 
{
    # EDIT + TODO !
    $_SESSION = array_replace($_SESSION, $_POST);
}

function check_connexion_form($pdo)
{
    if(!isset($_POST['pseudo']) or !isset($_POST['mot_de_passe']))
        return 'Vous n\'avez pas spécifié le pseudo ou le mot de passe.';
    if(is_pseudo_length_not_ok())
        return 'Votre pseudo doit faire entre ' . MIN_L_PSEUDO. ' et ' . MAX_L_PSEUDO . ' caractères.';
    if(is_password_length_not_ok())
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
            update_session_data();
            header('Location: ' . SUCCESSFUL_LOGIN_PAGE);
        }
    }
}
?>