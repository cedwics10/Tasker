<?php
//régle la date sur le fuseau horaire de la France
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

function getimplode(&$value, $key)
{
    $value = $key . '=' . $value;
}

function qmark_part($except = [], $new_g_ext = [])
{
    if(count($_GET) == 0 and count($new_g_ext) == 0)
    {
        return '?';
    }
	
	$get_pieces = $_GET;
	foreach($new_g_ext as $key => $value)
	{
		$get_pieces[$key] = $value;
	}


    array_walk($get_pieces, 'getimplode');
    return '?' . implode('&', $get_pieces);

}
?>