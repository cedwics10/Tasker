<?php
session_start();
include('constants.php');

setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');

try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=tasker', 'root', '');
}
catch (PDOException $e) 
{
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

function nouveau_cookie($nom, $valeur)
{
	setcookie($nom, $valeur, time() + NUMBER_OF_SECONDS_IN_A_YEAR);
	$_COOKIE[$nom] = $valeur;
}

function implode_get_pieces(&$value, $key = '')
{
    $value = $key . '=' . $value;
}

function make_stripped_get_args_link($get_args_to_remove = [], $mock_get_args = [], $extra_text = '')
{
    if(count($_GET) === 0 AND count($get_args_to_remove) === 0 AND count($mock_get_args) === 0 AND trim($extra_text) === '')
    {
        return '?';
    }
    
    ksort($_GET);

    foreach($get_args_to_remove AS $key_to_remove)
	{
        unset($_GET[$key_to_remove]);
	}
    
    $union_get_mock_get = array_replace($_GET,$mock_get_args);
    ksort($union_get_mock_get, SORT_STRING);

    array_walk($union_get_mock_get, 'implode_get_pieces');
    return '?' . implode('&amp;', $union_get_mock_get) . $extra_text;
}

function change_base_name(string $file_dir = '', string $new_basename = '')
{  
    $pathname = pathinfo($file_dir, PATHINFO_DIRNAME);
    return $pathname . '/' . $new_basename;
}


function avatar_properties_ok()
{
    list($avatar_width, $avatar_height, $type, $attr) = getimagesize($_FILES['avatar']['tmp_name']);
    $is_avatar_nottoobig = (intval($avatar_width) <= MAX_LENGTH_IMAGES
    AND intval($avatar_height) <= MAX_HEIGHT_IMAGES);
    return $is_avatar_nottoobig;
}

function check_uploaded_avatar()
{
    if(empty($_FILES['avatar']['tmp_name'])) 
    {
        return AVATAR_OK;
    }
    
    $avatar_extension = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);

    if(!in_array($avatar_extension, AVATAR_EXTENSION_OK))
    {
        return AVATAR_NOT_OK;
    }
    
    if(avatar_properties_ok())
    {
        return AVATAR_OK;
    }
    else
    {
        return AVATAR_NOT_OK;
    }
}
?>