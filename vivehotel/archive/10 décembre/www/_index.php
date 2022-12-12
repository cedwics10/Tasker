<?php
//page d'accueil du générateur
require "../include/inc_config.php";
require "../generateur/inc_generateur.php";

$message="";
$menu="";
//choix d'une base de données
if (isset($_POST["btSubmit"])) {
    $_SESSION["dbname"] = $_POST["dbname"];
	$_SESSION["prefixe"] = $_POST["prefixe"];
    $link = mysqli_connect("localhost","root","",$_SESSION["dbname"]);
    if ($_SESSION["dbname"]!="")
        $message=generateur($_SESSION["prefixe"]);
} 
      
if ($_SESSION["dbname"]!="") {
    $menu=getMenu();
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
        <h1>Générateur</h1>
		<b>Pour que le générateur fonctionne, vous devez :</b>
        <ul> 
		<li>Définir le nom des champs d'une table avec un préfixe correspondant aux 2 ou 3 premiers caractères du nom de la table (exemple, pour un préfixe de longueur 3, on définira dans la table "annuaire" les champs "ann_id", "ann_nom", ...etc.</li>
		<li>Toutes les tables doivent posséder une clé primaire de type entier Auto-incrémentée et nommée : [prefixe]_id</li>		
		</ul>
        <p>Vous pouvez modifier la longueur du préfixe dans le fichier "inc_config.php".</p>
        <form method="post">            
			<p>
				Longueur du préfixe : 
				<label for="deux">2<label>
				<input type="radio" name="prefixe" id="deux" value="2" <?=$_SESSION["prefixe"]==2 ? "checked" : "" ?> >
				&nbsp;&nbsp;
				<label for="trois">3<label>
				<input type="radio" name="prefixe" id="trois" value="3"  <?=$_SESSION["prefixe"]==3 ? "checked" : "" ?> >
			</p>
            <label for="dbname">Base de données : </label>
            <select name="dbname">
                <option value="">Sélectionner une base de données</option>
                <?php HTML_SELECT_Databases($_SESSION["dbname"]); ?>
            </select>
            <input type="submit" value="Générer !" name="btSubmit">
        </form>
        <ul>
            <?=$menu?>
        </ul>                    
    </main>
    <!-- pied de page -->
    <footer>
        <?php require "../include/inc_footer.php"; ?>
    </footer>

</body>

</html>