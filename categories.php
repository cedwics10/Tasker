<?php 
require_once('includes/head.php');

$stmt = $pdo->query("SELECT * FROM categories");
$result_exists = false;
?>

- Liste des catégories déjà créées :</br>
<?php
while($row = $stmt->fetch())
{
    echo $row['categorie']."<br />\n";
	if(!$result_exists)
	{
		$catagorie_exists = true;
	}
}

if(!$result_exists)
{
	echo 'Aucune catégorie n\'a été créée<br />';
}
?><br />
Revenir à l'accueil : <a href="index.php">cliquez-ici</a>
<hr /></br>