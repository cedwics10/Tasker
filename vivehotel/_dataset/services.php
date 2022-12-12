<?php
    $services = ["Piscine",
    "Bien être",
    "Remise en forme",
    "Thalassothérapie",
    "Tennis",
    "Parking",
    "Animal domestique accepté",
    "Wifi/internet",
    "Accessibilité personnes à mobilité réduite",
    "Garde d\'enfant sur demande",
    "Salle de fitness",
    "Petit déjeuner"
    ];

    
    //génération des services         
    $tab = [];
    for ($i = 0; $i < count($services); $i++) {
        $tab[] = "(null,'$services[$i]')";
    }
    $sql = "insert into services values " . implode(",", $tab);
    mysqli_query($link, $sql);
    echo "<p>génération de " . count($services) . " services</p>";
?> 