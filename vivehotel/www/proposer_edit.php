<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($pro_id==0) 
        //création d'un enregistrement
        $sql="insert into proposer values ('','$pro_prix','$pro_hotel','$pro_services')";
    else
        //maj d'un enregistrement
        $sql = "update proposer set pro_prix='$pro_prix',pro_hotel='$pro_hotel',pro_services='$pro_services' where pro_id=$pro_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:proposer_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from proposer where pro_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $pro_id=0;
        $pro_prix='';$pro_hotel='';$pro_services='';
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
        <h2>proposer : edition</h2>
        <form method="post">
            <input type="hidden" name="pro_id" value="<?= $pro_id ?>">
            <p>
                <label>pro_id</label> : <?= $pro_id ?>
            </p>
            <p>
<label for='pro_prix'>pro_prix</label>
<input type='text' name='pro_prix' id='pro_prix' value='<?= $pro_prix ?>'>
</p>

<p>
<label for='pro_hotel'>pro_hotel</label>
<input type='text' name='pro_hotel' id='pro_hotel' value='<?= $pro_hotel ?>'>
</p>

<p>
<label for='pro_services'>pro_services</label>
<input type='text' name='pro_services' id='pro_services' value='<?= $pro_services ?>'>
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