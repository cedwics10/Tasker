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
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Tasker - n'oubliez jamais les tâches à faire au quotidien</title>
  </head>
  <body>