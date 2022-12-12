<?php

//génération de personnels  
const NOMBRE_PERSONNEL = 20;
$nombre_hotel = 50;
$nombre_teletconseiller = 10;
$role = [
    "teleconseiller",
    "gestionnaire"
];
$tab = [];
for ($i = 1; $i <= $nombre_hotel; $i++) {
    $per_nom = "gestionnaire  $i";
    $per_identifiant = "gestionnaire$i";
    $per_mdp = password_hash($per_identifiant, PASSWORD_DEFAULT);
    $per_email = "g$i@gestionnaire.fr";
    $per_role = "gestionnaire";
    $per_hotel = $i;
    $tab[] = "(null,'$per_nom','$per_identifiant','$per_mdp','$per_email','$per_role','$per_hotel')";
}

for ($i = 1; $i <= $nombre_teletconseiller; $i++) {

    $per_nom = "teleconseiller $i";
    $per_identifiant = "teleconseiller$i";
    $per_mdp = password_hash($per_identifiant, PASSWORD_DEFAULT);
    $per_email = "t$i@teleconseiller.fr";
    $per_role = "teleconseiller";
    $per_hotel = 'null';
    $tab[] = "(null,'$per_nom','$per_identifiant','$per_mdp','$per_email','$per_role',$per_hotel)";
}
for ($i = 1; $i <= NOMBRE_PERSONNEL; $i++) {

    $per_nom = "personnel $i";
    $per_identifiant = "personnel$i";
    $per_mdp = password_hash($per_identifiant, PASSWORD_DEFAULT);
    $per_email = "p$i@personnel.fr";
    $per_role = "personnel";
    $per_hotel = $i;
    $tab[] = "(null,'$per_nom','$per_identifiant','$per_mdp','$per_email','$per_role','$per_hotel')";
}
$sql = "insert into personnel values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>génération de " . NOMBRE_PERSONNEL . " personnels</p>";
