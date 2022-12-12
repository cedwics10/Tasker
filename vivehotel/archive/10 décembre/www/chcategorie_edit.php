<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($chc_id==0) 
        //création d'un enregistrement
        $sql="insert into chcategorie values ('','$chc_categorie')";
    else
        //maj d'un enregistrement
        $sql = "update chcategorie set chc_categorie='$chc_categorie' where chc_id=$chc_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:chcategorie_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from chcategorie where chc_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $chc_id=0;
        $chc_categorie='';
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
        <h2>chcategorie : edition</h2>
        <form method="post">
            <input type="hidden" name="chc_id" value="<?= $chc_id ?>">
            <p>
                <label>chc_id</label> : <?= $chc_id ?>
            </p>
            <p>
<label for='chc_categorie'>chc_categorie</label>
<input type='text' name='chc_categorie' id='chc_categorie' value='<?= $chc_categorie ?>'>
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