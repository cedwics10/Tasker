<?php
require "../include/inc_config.php";
//applique la fonction mysqli_real_escape_string (protection contre l'injection SQL) à tous les élements de $_POST
$_POST = array_map("mres", $_POST);
extract($_POST);

if (isset($btsubmit)) {
    //si reception de données du formulaire
    if ($_id==0) 
        //création d'un enregistrement
        $sql="insert into taches values ('','$id_categorie','$nom_tache','$description','$date','$rappel','$importance','$complete')";
    else
        //maj d'un enregistrement
        $sql = "update taches set id_categorie='$id_categorie',nom_tache='$nom_tache',description='$description',date='$date',rappel='$rappel',importance='$importance',complete='$complete' where _id=$_id";

    //exécution de la requete insert/update puis redirection
    if (mysqli_query($link, $sql))
        header("location:taches_list.php");
    else
        echo mysqli_error($link);
        
} else {
    //récupération de l'identifiant de l'enregistrement à éditer
    $id = intval($_GET["id"]);
    if ($id > 0) {
        //edition d'un enregistrement existant
        $sql = "select * from taches where _id=$id";
        $resultat = mysqli_query($link, $sql);
        $ligne = mysqli_fetch_assoc($resultat);
        if ($ligne === false)
            echo mysqli_error($link);
        //applique lafonction htmlentities (protection contre l'injectrion javascript/HTML) à toutes les valeurs
        $ligne=array_map("mhe",$ligne);
        extract($ligne);
    } else {
        //création d'un nouvel enregistrement
        $_id=0;
        $id_categorie='';$nom_tache='';$description='';$date='';$rappel='';$importance='';$complete='';
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
        <h2>taches : edition</h2>
        <form method="post">
            <input type="hidden" name="_id" value="<?= $_id ?>">
            <p>
                <label>_id</label> : <?= $_id ?>
            </p>
            <p>
<label for='id_categorie'>id_categorie</label>
<input type='text' name='id_categorie' id='id_categorie' value='<?= $id_categorie ?>'>
</p>

<p>
<label for='nom_tache'>nom_tache</label>
<input type='text' name='nom_tache' id='nom_tache' value='<?= $nom_tache ?>'>
</p>

<p>
<label for='description'>description</label>
<input type='text' name='description' id='description' value='<?= $description ?>'>
</p>

<p>
<label for='date'>date</label>
<input type='text' name='date' id='date' value='<?= $date ?>'>
</p>

<p>
<label for='rappel'>rappel</label>
<input type='text' name='rappel' id='rappel' value='<?= $rappel ?>'>
</p>

<p>
<label for='importance'>importance</label>
<input type='text' name='importance' id='importance' value='<?= $importance ?>'>
</p>

<p>
<label for='complete'>complete</label>
<input type='text' name='complete' id='complete' value='<?= $complete ?>'>
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