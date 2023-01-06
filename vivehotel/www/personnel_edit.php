<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($per_id==0) 
        //création d'un enregistrement
        $sql="insert into personnel values ('','$per_nom','$per_identifiant','$per_mdp','$per_email','$per_role','$per_hotel')";
    else
        //maj d'un enregistrement
        $sql = "update personnel set per_nom='$per_nom',per_identifiant='$per_identifiant',per_mdp='$per_mdp',per_email='$per_email',per_role='$per_role',per_hotel='$per_hotel' where per_id=$per_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:personnel_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from personnel where per_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $per_id=0;
        $per_nom='';$per_identifiant='';$per_mdp='';$per_email='';$per_role='';$per_hotel='';
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
        <h2>personnel : edition</h2>
        <form method="post">
            <input type="hidden" name="per_id" value="<?= $per_id ?>">
            <p>
                <label>per_id</label> : <?= $per_id ?>
            </p>
            <p>
<label for='per_nom'>per_nom</label>
<input type='text' name='per_nom' id='per_nom' value='<?= $per_nom ?>'>
</p>

<p>
<label for='per_identifiant'>per_identifiant</label>
<input type='text' name='per_identifiant' id='per_identifiant' value='<?= $per_identifiant ?>'>
</p>

<p>
<label for='per_mdp'>per_mdp</label>
<input type='text' name='per_mdp' id='per_mdp' value='<?= $per_mdp ?>'>
</p>

<p>
<label for='per_email'>per_email</label>
<input type='text' name='per_email' id='per_email' value='<?= $per_email ?>'>
</p>

<p>
<label for='per_role'>per_role</label>
<input type='text' name='per_role' id='per_role' value='<?= $per_role ?>'>
</p>

<p>
<label for='per_hotel'>per_hotel</label>
<input type='text' name='per_hotel' id='per_hotel' value='<?= $per_hotel ?>'>
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