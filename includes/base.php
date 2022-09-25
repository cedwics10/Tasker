<?php 
try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=tasker', 'root', '');
}
catch (PDOException $e) 
{
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

function qmark_part()
{
    if(count($_GET) == 0)
    {
        return '?';
    }
    return '?' . implode('&', $_GET) ;
}
?>