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

function implodeGetWEqualMark(&$value, $key)
{
    $value = $key . '=' . $value;
}

function strip_get_args($get_args_to_remove = [], $mock_get_args = [], $extra_text = '')
{
    if(count($_GET) == 0  and count($get_args_to_remove) == 0 and count($mock_get_args) == 0 and trim($extra_text) == '')
    {
        return '?';
    }
    
    ksort($_GET);

    $arguments = [];
    foreach($get_args_to_remove as $key_to_remove)
	{
        unset($_GET[$key_to_remove]);
	}
    $union_get_mock_get = array_replace($_GET,$mock_get_args);
    ksort($union_get_mock_get, SORT_STRING);

    array_walk($union_get_mock_get, 'implodeGetWEqualMark');
    return '?' . implode('&amp;', $union_get_mock_get) . $extra_text;
}

function ChangeNameFile($file_dir, $new_basename = '')
{  
    $pathname = pathinfo($file_dir, PATHINFO_DIRNAME);
    return $pathname . '/' . $new_basename;
}

function check_uploaded_avatar()
{
    if(!empty($_FILES['avatar']['tmp_name'])) 
    {
        $avatar_extension = pathinfo($_FILES['avatar']['name'],PATHINFO_EXTENSION);
        list($avatar_width, $avatar_height, $type, $attr) = getimagesize($_FILES['avatar']['tmp_name']);

        if(in_array($avatar_extension, AVATAR_EXTENSION_OK))
        {
            if(
                !file_exists($_FILES['avatar']['tmp_name']) OR
                (
                    intval($avatar_width) <= MAX_LENGTH_IMAGES
                    AND intval($avatar_height) <= MAX_HEIGHT_IMAGES
                )
            )
            {
                return true;
            } 

            return false;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return true;
    }
}
?>