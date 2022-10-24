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

function qmark_part($args_to_ignore = [], $mock_get_args = [], $extra_text = '')
{
    if(count($_GET) == 0  and count($args_to_ignore) == 0 and count($mock_get_args) == 0 and trim($extra_text) == '')
    {
        return '?';
    }
    
    ksort($_GET);

    $arguments = [];
    $_GET_CLEANED = [];
    foreach($_GET as $key => $value)
	{
        if(!in_array($key,$args_to_ignore))
        {
            $_GET_CLEANED[$key] = $value;
        }
	}
    $union_get_mock_get = array_replace($_GET_CLEANED,$mock_get_args);
    ksort($union_get_mock_get, SORT_STRING);

    array_walk($union_get_mock_get, 'implodeGetWEqualMark');
    return '?' . implode('&amp;', $union_get_mock_get) . $extra_text;
}

function getExtension($f)
{
    $tab = explode(".", $f);
    if (count($tab) > 1) {
        return $tab[count($tab) - 1];
    } else
        return "";
}

function ChangeNameFile($file_dir, $new_basename = '')
{  
    $pathname = pathinfo($file_dir, PATHINFO_DIRNAME);
    return $pathname . '/' . $new_basename;
}

function check_avatar()
{
    if(!empty($_FILES['avatar']['tmp_name'])) 
    {
        if(in_array(pathinfo($_FILES['avatar']['tmp_name'],PATHINFO_EXTENSION), AVATAR_EXT_OK))
        {
            return(!file_exists($_FILES['avatar']['tmp_name']) OR
                (
                    intval($_FILES["avatar"]["size"][0]) <= 600
                    AND intval($_FILES["avatar"]["size"][1]) <= 600
                )
            ) ? true : false;
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