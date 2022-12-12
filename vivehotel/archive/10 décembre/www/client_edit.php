<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($cli_id==0) 
        //création d'un enregistrement
        $sql="insert into client values ('','$cli_nom','$cli_identifiant','$cli_mdp','$cli_email')";
    else
        //maj d'un enregistrement
        $sql = "update client set cli_nom='$cli_nom',cli_identifiant='$cli_identifiant',cli_mdp='$cli_mdp',cli_email='$cli_email' where cli_id=$cli_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:client_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from client where cli_id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $cli_id=0;
        $cli_nom='';$cli_identifiant='';$cli_mdp='';$cli_email='';
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
        <h2>client : edition</h2>
        <form method="post">
            <input type="hidden" name="cli_id" value="<?= $cli_id ?>">
            <p>
                <label>cli_id</label> : <?= $cli_id ?>
            </p>
            <p>
<label for='cli_nom'>cli_nom</label>
<input type='text' name='cli_nom' id='cli_nom' value='<?= $cli_nom ?>'>
</p>

<p>
<label for='cli_identifiant'>cli_identifiant</label>
<input type='text' name='cli_identifiant' id='cli_identifiant' value='<?= $cli_identifiant ?>'>
</p>

<p>
<label for='cli_mdp'>cli_mdp</label>
<input type='text' name='cli_mdp' id='cli_mdp' value='<?= $cli_mdp ?>'>
</p>

<p>
<label for='cli_email'>cli_email</label>
<input type='text' name='cli_email' id='cli_email' value='<?= $cli_email ?>'>
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