<?php 
require_once('includes/head.php');


function create_new_cateogry($categorie, $pdo)
{
	$sql_query = 'SELECT COUNT(*) FROM categories WHERE categories.categorie = "' . $categorie . '"';
	$res = $pdo->query($sql_query);
	$count_name = $res->fetchColumn();
	if($count_name == 0)
	{
		if(strlen($categorie) < 100 and strlen($categorie) >= 3)
		{
			$sql = "INSERT INTO categories (categorie) VALUES (?)";
			$stmt= $pdo->prepare($sql);
			$stmt->execute([$categorie]);
			echo "<b>La catégorie au nom de $categorie a été créé</b>";
		}
		else if(strlen($categorie) < 3)
		{
			echo '<b>Le nom que vous avez choisi est trop court</b>';
		}
		else
		{
			echo '<b>Le nom que vous avez choisi est trop long</b>';
		}
	}
	else
	{
		echo '<b>Cette catégorie a déjà été créé !</b>';
	}
}

function delete_categorie($id)
{
	$sql_query = 'SELECT COUNT(*) FROM categories WHERE  categories.id = "' . $id . '"';
	$res = $pdo->query($sql_query);
	$count_name = $res->fetchColumn();
	if($count_name == 1)
	{
		$sql_query = 'DELETE FROM categories WHERE categories.id = "' . $id . '"';
		$res = $pdo->query($sql_query);
		$count_name = $res->fetchColumn();
		echo '<b>La catégorie a été supprimé avec succès.</b>';
	}
	else
	{
		echo '<b>La catégorie que vous voulez effacer n\'existe pas</b>';
	}
}

function show_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	while($row = $stmt->fetch())
	{
		echo "* " . $row['categorie'] . " <a href=\"categories.php?id=" . $row['id'] . "\">X</a><br />\n";
		if(!$result_exists)
		{
			$result_exists = true;
		}
	}
}
?>
Gérez vos catégories créées.</br></br>
<?php
if(isset($_POST['category']))
{
	create_new_cateogry($_POST['category'], $pdo);
}
?><br />
<u>- Liste des catégories déjà créées :</u></br>
<?php
show_categories($pdo)
?><hr />
Créer une nouvelle catégorie :
<form action="categories.php" method="post">
<input type="text" name="category"/> <input type="submit">
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>