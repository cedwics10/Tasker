<?php

//génération de Categorie_chambre  
$hocategorie = [
    "2 étoiles",
    "3 étoiles",
    "4 étoiles",
    "5 étoiles",
    "Palace"
];
 
$tab = [];
foreach ($hocategorie as $hoc_nom) {
    $tab[] = "(null,'$hoc_nom')";
}
$sql = "insert into hocategorie values " . implode(",", $tab);
mysqli_query($link, $sql);
echo '<p>génération de ' . count($hocategorie) . ' catégorie de l\'hôtel</p>';
?>
