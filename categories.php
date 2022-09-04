<?php 
require_once('includes/head.php');

function show_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT * FROM categories");
	while($row = $stmt->fetch())
	{
		echo "* " . $row['categorie'] . "<br />\n";
		if(!$result_exists)
		{
			$result_exists = true;
		}
	}
	
	if(!$result_exists)
	{
		echo 'Aucune catégorie n\'a été créée<br />';
	}
}
?>
Gérez vos catégories créées.</br></br>
- Liste des catégories déjà créées :</br>
<?php
show_categories($pdo)
?><hr />
Créer une nouvelle catégorie :
<form action="categories.php" method="post">
<input type="text" name="categorie"/> <input type="submit">
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>