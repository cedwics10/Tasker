<?php

$tar_id = [];
$tar_prix = [];
$tar_hocategorie = [];
$tar_chcategorie = [];

$tab = [];

$tarifs = [
    '2 étoiles' => ['Standard' => '50', 'Supérieure' => '60', 'Luxe' => '70', 'Suite' => '80'],
    '3 étoiles' => ['Standard' => '70', 'Supérieure' => '80', 'Luxe' => '90', 'Suite' => '100'],
    '4 étoiles' => ['Standard' => '85', 'Supérieure' => '110', 'Luxe' => '150', 'Suite' => '200'],
    '5 étoiles' => ['Standard' => '120', 'Supérieure' => '230', 'Luxe' => '999', 'Suite' => '1500'],
    'Palace' => ['Standard' => '0', 'Supérieure' => '0', 'Luxe' => '1200', 'Suite' => '2100']
];

$nb_tarifs = 0;
$hoc = 1;
foreach ($hocategorie as $hocat) {
    $chc = 1;
    foreach ($chcategorie as $chcat) {

        $tar_id = 'NULL';
        $tar_prix = $tarifs[$hocat][$chcat];
        $tar_hocategorie = $hoc;
        $tar_chcategorie = $chc;

       
        if($tar_prix != '0')
        {
            $tab[] = "(null,'$tar_prix', '$tar_hocategorie', '$tar_chcategorie')";
            $nb_tarifs++;
        }
        $chc++;
        
    }
    $hoc++;
}


$sql = "insert into tarifer values " . implode(",", $tab);
mysqli_query($link, $sql);

echo '<p>génération de ' .($nb_tarifs) . ' tarifs</p>';
