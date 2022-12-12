<?php
require "../include/inc_config.php";
//identifiant de l'enregistrement à supprimer
$id=intval($_GET["id"]);
$sql="delete from personnel where per_id=$id";
//exécute la requete delete
if (mysqli_query($link,$sql))
    //si la requete est OK alors redirection
    header("location:personnel_list.php");
else    
    echo mysqli_error($link);
?>