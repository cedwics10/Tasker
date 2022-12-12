<?php
//affiche la liste des enregistrements de la table AVION
require "../include/inc_config.php";
$sql="select * from hotel";
//envoie la requête au serveur mysql, et récupère un pointeur sur le jeu de données
$resultat=mysqli_query($link,$sql);
//Charge toutes les données dans un tableau à 2 dimsensions
$data=mysqli_fetch_all($resultat,MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require "../include/inc_head.php"; ?>
</head>
<body>
    <!-- lien de navigation pour lecteur d'écran -->
    <a href="#main" class="sr-only">aller au contenu principal</a>
     <!-- entete de page -->
    <header>        
        <?php require "../include/inc_header.php"; ?>
    </header>
    <!-- menu de navigation -->
    <nav>
        <?php require "../include/inc_menu.php"; ?>
    </nav>
    <!-- contenu principal -->
    <main id="main">
        <h2>hotel</h2>     
        <p><a href="hotel_edit.php?id=0">Créer un enregistrement</a></p> 
        <table>
            <thead>
                <tr>
                    <?php
                        if (count($data)>0)
                            foreach($data[0] as $champ => $valeur)
                                echo "<th>$champ</th>";
                    ?>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <?php
            foreach($data as $i => $ligne) {
                echo "<tr>";
                foreach($ligne as $champ => $valeur)  {
                    echo "<td>" . htmlentities($valeur,ENT_QUOTES,"UTF-8") . "</td>";
                }
                $id=$ligne["hot_id"];
                echo "<td><a href='hotel_edit.php?id=$id'>modifier</a></td>";
                echo "<td><a href='hotel_delete.php?id=$id'>supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <!-- pied de page -->
    <footer>
        <?php require "../include/inc_footer.php"; ?>
    </footer>

</body>
</html>