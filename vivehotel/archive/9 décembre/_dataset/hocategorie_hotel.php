<?php

//génération de Categorie_chambre  
$categorie = [
    "2 étoiles",
    "3 étoiles",
    "4 étoiles",
    "5 étoiles",
    "Palace"
]; 

$tab = [];
foreach ($categorie as $hoc_nom) {
    
    $tab[] = "(null,'$hoc_nom')";
}
$sql = "insert into hocategorie values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>génération de catégorie de l'hôtel</p>";
?>
