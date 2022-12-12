<?php


//génération de Categorie_chambre  
$chcategorie = [
    "Standard",
    "Supérieure",
    "Luxe",
    "Suite"
]; 
$tab = [];
foreach ($chcategorie as $chc_nom) {
    $tab[] = "(null,'$chc_nom')";
}
$sql = "insert into chcategorie values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>génération de catégorie de chambre</p>";
?>

