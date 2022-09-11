<?php 
require_once('includes/head.html');
require_once('includes/include_categories.php');
?>
<h1 style="text-align: center;">Gérez vos catégories créées.</h1></br></br>
<?php
if(isset($_POST['category']))
{
	create_new_cateogry($_POST['category'], $pdo);
}
else if(isset($_GET['delete_id']))
{
	delete_category($_GET['delete_id'], $pdo);
}
?><br />
<u>- Liste des catégories déjà créées :</u></br>
<?php
show_categories($pdo)
?><hr />
Créer une nouvelle catégorie :
<form action="categories.php" method="post">
	<input type="text" name="category"/>
	<input type="submit">
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
	require_once('includes/footer.html');
?>