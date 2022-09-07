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
    <title>Todo list - n'oubliez jamais les tâches à faire au quotidien</title>
	<link rel='stylesheet' type='text/css' href='design.css'  />
  </head>
  <body>