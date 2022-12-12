<?php
//affiche la liste des enregistrements de la table AVION
require "../include/inc_config.php";
$sql="select * from [table]";
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
        <h2>[table]</h2>     
        <p><a href="[table]_edit.php?id=0">Créer un enregistrement</a></p> 
        <table>
            <thead>
                <tr>
                    [ListeChampsTH]
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
            foreach($data as $i => $ligne) {
                $ligne=array_map("mhe",$ligne);
                extract($ligne); 
                $id=$ligne["[prefixe]_id"];
                ?>
                <tr>
                [ListeValeursTD]
                <td><a href='[table]_edit.php?id=<?=$id?>'>modifier</a></td>
                <td><a href='[table]_delete.php?id=<?=$id?>'>supprimer</a></td>
                </tr>
            <?php } //fin foreach ?>
        </table>
    </main>
    <!-- pied de page -->
    <footer>
        <?php require "../include/inc_footer.php"; ?>
    </footer>

</body>
</html>