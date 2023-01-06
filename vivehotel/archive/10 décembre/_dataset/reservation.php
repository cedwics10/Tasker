<?php
const R_THREE_DAYS = 60 * 60 * 24 * 3;

const R_STARTING_YEAR = '2021';
const R_STARTING_DAY = '1';
const R_STARTING_MONTH = '1';
const R_FINAL_MONTH = '12';

$current_hour = 0;
$new_days = 0;
$i = 0;
$tab = [];

for($id_hotel = 1; $id_hotel < NOMBRE_HOTEL;$id_hotel++)
{
    $nb_rooms = ($id_hotel % 5 == 0) ? NB_CHAMBRE_P_HOTEL / 2 : 0;

    for($nb_month = R_STARTING_MONTH;$nb_month<R_FINAL_MONTH;$nb_month++)
    {
        for($no_chambre = 1; $no_chambre++;$no_chambre <= $nb_rooms) {
            
            $res_id = 'NULL';

            $timestamp_debut = mktime($current_hour, 0, 0, $nb_month,1, R_STARTING_YEAR);
            
            // Transformer les champs de date en date

            $res_date_creation =  date('Y-m-d H:i:s', $timestamp_debut - R_THREE_DAYS);  
            $res_date_debut = date('Y-m-d H:i:s', $timestamp_debut);
            
            $res_date_debut = mktime($current_hour, 0, 0, $nb_month + 1,1, R_STARTING_YEAR);
            
            $res_etat = mt_rand(0,1);
            $res_client = mt_rand(1,NOMBRE_DE_CLIENTS);
            $res_hotel = $id_hotel;
            $res_chambre = $no_chambre;

            $tab[] = "(NULL,'$res_date_creation','$res_date_debut','$res_date_maj','$res_date_fin','$res_etat','$res_client','$res_hotel','$res_chambre')";	

        }
    }
}

print(implode(',', $tab));
exit();

?>