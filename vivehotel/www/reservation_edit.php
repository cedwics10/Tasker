<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($res_id==0) 
        //création d'un enregistrement
        $sql="insert into reservation values ('','$res_date_creation','$res_date_debut','$res_date_maj','$res_date_fin','$res_etat','$res_client','$res_hotel','$res_chambre')";
    else
        //maj d'un enregistrement
        $sql = "update reservation set res_date_creation='$res_date_creation',res_date_debut='$res_date_debut',res_date_maj='$res_date_maj',res_date_fin='$res_date_fin',res_etat='$res_etat',res_client='$res_client',res_hotel='$res_hotel',res_chambre='$res_chambre' where res_id=$res_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:reservation_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from reservation where res_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $res_id=0;
        $res_date_creation='';$res_date_debut='';$res_date_maj='';$res_date_fin='';$res_etat='';$res_client='';$res_hotel='';$res_chambre='';
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
        <h2>reservation : edition</h2>
        <form method="post">
            <input type="hidden" name="res_id" value="<?= $res_id ?>">
            <p>
                <label>res_id</label> : <?= $res_id ?>
            </p>
            <p>
<label for='res_date_creation'>res_date_creation</label>
<input type='text' name='res_date_creation' id='res_date_creation' value='<?= $res_date_creation ?>'>
</p>

<p>
<label for='res_date_debut'>res_date_debut</label>
<input type='text' name='res_date_debut' id='res_date_debut' value='<?= $res_date_debut ?>'>
</p>

<p>
<label for='res_date_maj'>res_date_maj</label>
<input type='text' name='res_date_maj' id='res_date_maj' value='<?= $res_date_maj ?>'>
</p>

<p>
<label for='res_date_fin'>res_date_fin</label>
<input type='text' name='res_date_fin' id='res_date_fin' value='<?= $res_date_fin ?>'>
</p>

<p>
<label for='res_etat'>res_etat</label>
<input type='text' name='res_etat' id='res_etat' value='<?= $res_etat ?>'>
</p>

<p>
<label for='res_client'>res_client</label>
<input type='text' name='res_client' id='res_client' value='<?= $res_client ?>'>
</p>

<p>
<label for='res_hotel'>res_hotel</label>
<input type='text' name='res_hotel' id='res_hotel' value='<?= $res_hotel ?>'>
</p>

<p>
<label for='res_chambre'>res_chambre</label>
<input type='text' name='res_chambre' id='res_chambre' value='<?= $res_chambre ?>'>
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