<?php      
$tab = [];
$lkey_services = [];
$id_services = range(1,count($services)-1);
for ($hotel = 1; $hotel < NOMBRE_HOTEL; $hotel++) {
    $lkey_services[] = mt_rand(2,4)-1;
    shuffle($id_services);
    $services_prop = array_slice($id_services,0, end($lkey_services));
    foreach($services_prop as $id_service)
    {
        $pro_services = $id_service;
        $pro_hotel = $hotel;
        $pro_prix = mt_rand(0,100);
        $tab[] = "(NULL,'$pro_prix','$pro_hotel','$pro_services')";
    }
}
$sql = "insert into proposer values " . implode(",", $tab);
mysqli_query($link, $sql);
echo "<p>Génération de ? propositions.</p>";
?> 

?>