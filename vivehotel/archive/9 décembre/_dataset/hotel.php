<?php

//génération de personnels  
const NOMBRE_HOTEL = 50;

$tab = [];
for ($i = 1; $i <= NOMBRE_HOTEL; $i++) {
    $hot_statut = "hôtel $i";
    $hot_nom = "hôtel $i";
    $hot_adresse = $i;
    $hot_departement = mt_rand(01,95);
    $hot_description = "text $i";
    $hot_longitude = mt_rand(-180,180);
    $hot_latitude = mt_rand(-90,90);
    $hot_hocategorie = $categorie[array_rand($categorie)];
    $tab[] = "(null,'$hot_statut','$hot_nom','$hot_adresse','$hot_departement','$hot_description','$hot_longitude','$hot_latitude','$hot_hocategorie')";
}
$sql = "insert into hotel values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>génération de " . NOMBRE_HOTEL . " hôtels</p>";

/*
Hotel
- hot_id (AI)
- hot_statut (varchar(500))
- hot_nom (varchar(500))
- hot_adresse (varchar(500))
- hot_departement (int)
- hot_description (text)
- hot_longitude (int)
- hot_latitude (int)
- hot_hocategorie (FK)
*/
?>