<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($hot_id==0) 
        //création d'un enregistrement
        $sql="insert into hotel values ('','$hot_statut','$hot_nom','$hot_adresse','$hot_departement','$hot_description','$hot_longitude','$hot_latitude','$hot_hocategorie')";
    else
        //maj d'un enregistrement
        $sql = "update hotel set hot_statut='$hot_statut',hot_nom='$hot_nom',hot_adresse='$hot_adresse',hot_departement='$hot_departement',hot_description='$hot_description',hot_longitude='$hot_longitude',hot_latitude='$hot_latitude',hot_hocategorie='$hot_hocategorie' where hot_id=$hot_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:hotel_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from hotel where hot_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $hot_id=0;
        $hot_statut='';$hot_nom='';$hot_adresse='';$hot_departement='';$hot_description='';$hot_longitude='';$hot_latitude='';$hot_hocategorie='';
    }
}
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
        <h2>hotel : edition</h2>
        <form method="post">
            <input type="hidden" name="hot_id" value="<?= $hot_id ?>">
            <p>
                <label>hot_id</label> : <?= $hot_id ?>
            </p>
            <p>
<label for='hot_statut'>hot_statut</label>
<input type='text' name='hot_statut' id='hot_statut' value='<?= $hot_statut ?>'>
</p>

<p>
<label for='hot_nom'>hot_nom</label>
<input type='text' name='hot_nom' id='hot_nom' value='<?= $hot_nom ?>'>
</p>

<p>
<label for='hot_adresse'>hot_adresse</label>
<input type='text' name='hot_adresse' id='hot_adresse' value='<?= $hot_adresse ?>'>
</p>

<p>
<label for='hot_departement'>hot_departement</label>
<input type='text' name='hot_departement' id='hot_departement' value='<?= $hot_departement ?>'>
</p>

<p>
<label for='hot_description'>hot_description</label>
<input type='text' name='hot_description' id='hot_description' value='<?= $hot_description ?>'>
</p>

<p>
<label for='hot_longitude'>hot_longitude</label>
<input type='text' name='hot_longitude' id='hot_longitude' value='<?= $hot_longitude ?>'>
</p>

<p>
<label for='hot_latitude'>hot_latitude</label>
<input type='text' name='hot_latitude' id='hot_latitude' value='<?= $hot_latitude ?>'>
</p>

<p>
<label for='hot_hocategorie'>hot_hocategorie</label>
<input type='text' name='hot_hocategorie' id='hot_hocategorie' value='<?= $hot_hocategorie ?>'>
</p>


            <p>
                <input type="submit" name="btsubmit" value="Envoyer">
            </p>
        </form>
    </main>
    <!-- pied de page -->
    <footer>
        <?php require "../include/inc_footer.php"; ?>
    </footer>

</body>

</html>