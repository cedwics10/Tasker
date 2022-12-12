<?php
require "inc_fonction.php";
session_start();
const NOM_SITE="Générateur";

//base de données sélectionnée
$_SESSION["dbname"] = $_SESSION["dbname"] ?? "";
//longueur du préfixe des champs
$_SESSION["prefixe"] = $_SESSION["prefixe"] ?? 3;
//connexion à la base de données
$link = mysqli_connect("localhost","root","",$_SESSION["dbname"]);
mysqli_set_charset($link,"utf8");

?>