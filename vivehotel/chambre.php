<?php

//génération de chambre

const NOMBRE_HOTEL = 50;
$lit1 = [
    "2 Lits simples",
    "Lit double standard Queen Size",
	"Lit double Confort",
	"Lit double King Size",
	"1 lit double et un lit simple"
];
$lit2 = [
    "2 Lits simples",
    "Lit double standard Queen Size",
	"Lit double Confort",
	"Lit double King Size",
	"1 lit double et un lit simple"
];
$tab = [];
for ($i = 1; $i <= NOMBRE_HOTEL; $i++) {
    $nombre_chambre = mt_rand(10,200);
    for ($j=1; $j<=$nombre_chambre; $j++) {
        $cha_numero = "chambre " . mt_rand(10,200);
        $cha_statut = "chambre $i";
        $cha_surface = mt_rand(10,40);
        $cha_typelit1 = array_rand($lit1);
        $cha_typelit2 = array_rand($lit2);
        $cha_description = "text $i";
        $cha_jacuzzi = mt_rand(0,1);
        $cha_balcon = mt_rand(0,1);
        $cha_wifi = mt_rand(0,1);
        $cha_minibar = mt_rand(0,1);
        $cha_coffre = mt_rand(0,1);
        $cha_vue = mt_rand(0,1);
        $cha_chcategorie = mt_rand(1,count($chcategorie));
    }
    $tab[] = "(null,'$cha_numero','$cha_statut','$cha_surface','$cha_typelit1','$cha_typelit2',
    '$cha_description','$cha_jacuzzi','$cha_balcon','$cha_wifi','$cha_minibar','$cha_coffre','$cha_vue',
    '$cha_chcategorie')";
}
$sql = "insert into chambre values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>génération de " . $nombre_chambre . " chambres</p>";

/*
chambre
    cha_id int auto_increment primary key,
    cha_numero varchar(500) not null,
    cha_statut varchar(500) not null,
    cha_surface int not null,    
    cha_typelit1 varchar(500) not null, 
    cha_typelit2 varchar(500),
    cha_description text not null,
    cha_jacuzzi boolean not null,
    cha_balcon boolean not null,
    cha_wifi boolean not null,
    cha_minibar boolean not null,
    cha_coffre boolean not null,
    cha_vue boolean not null,
    cha_chcategorie int not null 
*/
?>