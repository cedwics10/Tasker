<?php 

//génération de personnels  
 CONST NOMBRE_PERSONNEL=20;
 $role = [
    "téléconseillée",
    "gestionnaire"
];
 $tab = [];
 for ($i = 1; $i <= NOMBRE_PERSONNEL; $i++) {
    
     $per_nom = "personnel $i";
     $per_identifiant = "personnel $i";
     // password_hash($mot_de_passe, , PASSWORD_DEFAULT); - crypte le mot de passe $mot_de_passe
     $per_mdp = password_hash("personnel$i", PASSWORD_DEFAULT);
     $per_email = "p$i@personnel.fr";
     
foreach ($role as $per_role)
     $tab[] = "(null,'$per_nom','$per_identifiant','$per_mdp','$per_email','$per_role','$per_hotel)";
 }
 $sql = "insert into personnel values " . implode(",", $tab);
 mysqli_query($link, $sql);
 echo "<p>génération de " . NOMBRE_PERSONNEL . " personnels</p>";


