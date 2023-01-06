<?php
const NB_CHAMBRE_P_HOTEL = 20;
//génération de chambre
$tab = [];
$nb_chambre_gene = [];
for ($i = 1; $i <= NOMBRE_HOTEL; $i++) {
    for ($j=1; $j<=NB_CHAMBRE_P_HOTEL; $j++) {
        $cha_numero = $j;
        $cha_statut = mt_rand(0,1);
        $cha_surface = mt_rand(10,40);
        $type_lits = array_rand($lits);
        $cha_typelit1 = $lits[$type_lits][0];
        $cha_typelit2 = $lits[$type_lits][1];  

        $cha_description = "text $i <a href=\'index.php\'>Accueil</a>";
        $cha_jacuzzi = mt_rand(0,1);
        $cha_balcon = mt_rand(0,1);
        $cha_wifi = mt_rand(0,1);
        $cha_minibar = mt_rand(0,1);
        $cha_coffre = mt_rand(0,1);
        $cha_vue = mt_rand(0,1);
        $cha_chcategorie = mt_rand(1,count($chcategorie));
		
        $chtypelit2 = ($cha_typelit2 == 'NULL') ? 'NULL' : "'$cha_typelit2'";

		$tab[] = "(null,'$cha_numero','$cha_statut','$cha_surface','$cha_typelit1', $chtypelit2,
		'$cha_description','$cha_jacuzzi','$cha_balcon','$cha_wifi','$cha_minibar','$cha_coffre','$cha_vue',
		'$cha_chcategorie')";
    }
}
$sql = "insert into chambre values " . implode(",", $tab);

mysqli_query($link, $sql);
echo "<p>génération de " . strval(NB_CHAMBRE_P_HOTEL * NOMBRE_HOTEL) . " chambres</p>";

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
