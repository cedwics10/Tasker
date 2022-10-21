<?php
session_start();

const MIN_L_MDP = 8;
const MAX_L_MDP = 20;
const MIN_L_PSEUDO = 3;
const MAX_L_PSEUDO = 20;

//régle la date sur le fuseau horaire de la France
setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');


const AVATAR_EXT_OK = ["jpg", "jpeg", "png", "bmp", "gif"];

try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=tasker', 'root', '');
}
catch (PDOException $e) 
{
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

function implodeEqualMarkGetimplode(&$value, $key)
{
    $value = $key . '=' . $value;
}

function qmark_part($args_to_ignore = [], $mock_get_args = [], $extra_text = '')
{
    if(
        count($_GET) == 0 
        and count($args_to_ignore) == 0
        and count($mock_get_args) == 0
        and trim($extra_text) == ''
    )
    {
        return '?';
    }
    
    $arguments = [];
    $union_get_mock_get = ($_GET + $mock_get_args);
	foreach($union_get_mock_get as $key => $value)
	{
        if(!in_array($key,$args_to_ignore))
        {
            $arguments[$key] = $value;
        }
	}

    array_walk($arguments, 'implodeEqualMarkGetimplode');
    return '?' . implode('&amp;', $arguments) . $extra_text;

}

function getExtension(string $f): string
{
    $tab = explode(".", $f);
    if (count($tab) > 1) {
        return $tab[count($tab) - 1];
    } else
        return "";
}

function ChangeNameFile($path, $new_name)
{
    $path_pieces = explode('/', $path);
    $nb_pieces = count($path_pieces)-1;

    $path_pieces[$nb_pieces] = explode('.', $path_pieces[$nb_pieces]);
    $path_pieces[$nb_pieces][0] = $new_name;
    $path_pieces[$nb_pieces] = implode('.', $path_pieces[$nb_pieces]);

    $path = implode('/', $path_pieces);
    return $path;
}

function check_avatar()
{
    if(!empty($_FILES["avatar"]["tmp_name"])) 
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
        
        return $image_conf;
    }
    else
    {
        return 'true';
    }
}
?>