<?php
// $no_chambres_hotels;
$id_clients = range(1,NOMBRE_DE_CLIENTS);
shuffle($id_clients);

$k = 1;
$tab = [];

for ($hotel = 1; $hotel < NOMBRE_HOTEL; $hotel++) // 50 hôtels
{
    for ($jour = 1; $jour < 365; $jour += 7) { // dates
        shuffle($no_chambres_hotels[$hotel]);
        $selected_no = array_slice($no_chambres_hotels[$hotel], 0, 4);

        foreach ($no_chambres_hotels[$hotel] as $cle_chambre) { //  5 chambres.
            
            $res_id	= 'NULL';

            $res_timestamp_creation = mktime(15,0,0,1,$jour-3,2021);
            $res_date_creation	= date('Y-m-d', $res_timestamp_creation);

            $res_timestamp_debut = mktime(15,0,0,1,$jour,2021);
            $res_date_debut	= date('Y-m-d', $res_timestamp_debut);

            $res_timestamp_maj = mktime(11,0,0,1,$jour+7,2021);
            $res_date_maj = date('Y-m-d H:i:s', $res_timestamp_maj);

            $res_timestamp_fin = mktime(11,0,0,1,$jour+15,2021);
            $res_date_fin	= date('Y-m-d', $res_timestamp_fin);

            $res_etat	= 'Terminé';
            $res_client	= $id_clients[$k % NOMBRE_DE_CLIENTS];
            $res_hotel	= $hotel;
            $res_chambre= $cle_chambre;
            
            $k++;     
            $tab[] = "(NULL,'$res_date_creation','$res_date_debut','$res_date_maj','$res_date_fin','$res_etat','$res_client','$res_hotel','$res_chambre')";
        }
    }
}

    $tabs = array_chunk($tab, 100);
    foreach($tabs as $tab)
    {
        $sql = 'INSERT INTO reservation VALUES ' . implode(',', $tab);
        print($sql);
        print('<br />');
        mysqli_query($link, $sql) or die(mysqli_error($link));
    }
