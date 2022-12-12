<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($tar_id==0) 
        //création d'un enregistrement
        $sql="insert into tarifer values ('','$tar_prix','$tar_hocategorie','$tar_chcategorie')";
    else
        //maj d'un enregistrement
        $sql = "update tarifer set tar_prix='$tar_prix',tar_hocategorie='$tar_hocategorie',tar_chcategorie='$tar_chcategorie' where tar_id=$tar_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:tarifer_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from tarifer where tar_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $tar_id=0;
        $tar_prix='';$tar_hocategorie='';$tar_chcategorie='';
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
        <h2>tarifer : edition</h2>
        <form method="post">
            <input type="hidden" name="tar_id" value="<?= $tar_id ?>">
            <p>
                <label>tar_id</label> : <?= $tar_id ?>
            </p>
            <p>
<label for='tar_prix'>tar_prix</label>
<input type='text' name='tar_prix' id='tar_prix' value='<?= $tar_prix ?>'>
</p>

<p>
<label for='tar_hocategorie'>tar_hocategorie</label>
<input type='text' name='tar_hocategorie' id='tar_hocategorie' value='<?= $tar_hocategorie ?>'>
</p>

<p>
<label for='tar_chcategorie'>tar_chcategorie</label>
<input type='text' name='tar_chcategorie' id='tar_chcategorie' value='<?= $tar_chcategorie ?>'>
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