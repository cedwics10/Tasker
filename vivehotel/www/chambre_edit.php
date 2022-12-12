<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($cha_id==0) 
        //création d'un enregistrement
        $sql="insert into chambre values ('','$cha_numero','$cha_statut','$cha_surface','$cha_typelit1','$cha_typelit2','$cha_description','$cha_jacuzzi','$cha_balcon','$cha_wifi','$cha_minibar','$cha_coffre','$cha_vue','$cha_chcategorie')";
    else
        //maj d'un enregistrement
        $sql = "update chambre set cha_numero='$cha_numero',cha_statut='$cha_statut',cha_surface='$cha_surface',cha_typelit1='$cha_typelit1',cha_typelit2='$cha_typelit2',cha_description='$cha_description',cha_jacuzzi='$cha_jacuzzi',cha_balcon='$cha_balcon',cha_wifi='$cha_wifi',cha_minibar='$cha_minibar',cha_coffre='$cha_coffre',cha_vue='$cha_vue',cha_chcategorie='$cha_chcategorie' where cha_id=$cha_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:chambre_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from chambre where cha_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $cha_id=0;
        $cha_numero='';$cha_statut='';$cha_surface='';$cha_typelit1='';$cha_typelit2='';$cha_description='';$cha_jacuzzi='';$cha_balcon='';$cha_wifi='';$cha_minibar='';$cha_coffre='';$cha_vue='';$cha_chcategorie='';
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
        <h2>chambre : edition</h2>
        <form method="post">
            <input type="hidden" name="cha_id" value="<?= $cha_id ?>">
            <p>
                <label>cha_id</label> : <?= $cha_id ?>
            </p>
            <p>
<label for='cha_numero'>cha_numero</label>
<input type='text' name='cha_numero' id='cha_numero' value='<?= $cha_numero ?>'>
</p>

<p>
<label for='cha_statut'>cha_statut</label>
<input type='text' name='cha_statut' id='cha_statut' value='<?= $cha_statut ?>'>
</p>

<p>
<label for='cha_surface'>cha_surface</label>
<input type='text' name='cha_surface' id='cha_surface' value='<?= $cha_surface ?>'>
</p>

<p>
<label for='cha_typelit1'>cha_typelit1</label>
<input type='text' name='cha_typelit1' id='cha_typelit1' value='<?= $cha_typelit1 ?>'>
</p>

<p>
<label for='cha_typelit2'>cha_typelit2</label>
<input type='text' name='cha_typelit2' id='cha_typelit2' value='<?= $cha_typelit2 ?>'>
</p>

<p>
<label for='cha_description'>cha_description</label>
<input type='text' name='cha_description' id='cha_description' value='<?= $cha_description ?>'>
</p>

<p>
<label for='cha_jacuzzi'>cha_jacuzzi</label>
<input type='text' name='cha_jacuzzi' id='cha_jacuzzi' value='<?= $cha_jacuzzi ?>'>
</p>

<p>
<label for='cha_balcon'>cha_balcon</label>
<input type='text' name='cha_balcon' id='cha_balcon' value='<?= $cha_balcon ?>'>
</p>

<p>
<label for='cha_wifi'>cha_wifi</label>
<input type='text' name='cha_wifi' id='cha_wifi' value='<?= $cha_wifi ?>'>
</p>

<p>
<label for='cha_minibar'>cha_minibar</label>
<input type='text' name='cha_minibar' id='cha_minibar' value='<?= $cha_minibar ?>'>
</p>

<p>
<label for='cha_coffre'>cha_coffre</label>
<input type='text' name='cha_coffre' id='cha_coffre' value='<?= $cha_coffre ?>'>
</p>

<p>
<label for='cha_vue'>cha_vue</label>
<input type='text' name='cha_vue' id='cha_vue' value='<?= $cha_vue ?>'>
</p>

<p>
<label for='cha_chcategorie'>cha_chcategorie</label>
<input type='text' name='cha_chcategorie' id='cha_chcategorie' value='<?= $cha_chcategorie ?>'>
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