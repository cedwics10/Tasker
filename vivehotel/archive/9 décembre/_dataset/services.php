 
 <?php
        const NOMBRE_SERVICES = 50;

        //génération des services         
        $tab = [];
        for ($i = 1; $i <= NOMBRE_SERVICES; $i++) {
            $ser_nom = "nom de service : $i";
            $tab[] = "(null,'$ser_nom')";
        }
        $sql = "insert into services values " . implode(",", $tab);
        mysqli_query($link, $sql);
        echo "<p>génération de " . NOMBRE_SERVICES . " services</p>";
?> 