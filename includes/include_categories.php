<?php
require_once('includes/base.php');
$form_usage = 'Créer';

function create_new_cateogry($categorie, $pdo)
{
	$message_user = '';
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
			$message_user = "<b>La catégorie au nom de $categorie a été créé</b>";
		}
		else if(strlen($categorie) < 3)
		{
			$message_user = '<b>Le nom que vous avez choisi est trop court</b>';
		}
		else
		{
			$message_user = '<b>Le nom que vous avez choisi est trop long</b>';
		}
	}
	else
	{
		$message_user = '<b>Cette catégorie a déjà été créé !</b>';
	}

	return $message_user;
}

function delete_category($id, $pdo)
{
	$message_user = '';

	$sql_query = 'SELECT COUNT(*) FROM categories WHERE categories.id = ?';
	$stmt = $pdo->prepare($sql_query);
	$stmt->execute([$id]);
	
	$count_name = $stmt->fetchColumn();
	if($count_name == 1)
	{
		$sql = "DELETE FROM taches WHERE id_categorie = ?";
		$stmt= $pdo->prepare($sql);
		$stmt->execute([$id]);
		
		
		$sql_query = 'DELETE FROM categories WHERE categories.id = ?';
		$stmt= $pdo->prepare($sql_query);
		$stmt->execute([$id]);
		$message_user =  '<b>La catégorie a été supprimé avec succès.</b>';
	}
	else
	{
		$message_user =  '<b>La catégorie que vous voulez effacer n\'existe pas</b>';
	}

	return $message_user;
}

function show_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	while($row = $stmt->fetch())
	{
		echo "<tr>" . PHP_EOL 
		. "<td>" . $row['categorie'] . "</td>" . PHP_EOL 
		. "<td><a href=\"categories.php?delete_id=" . $row['id'] . "\">X</a></td>" . PHP_EOL
		. "</tr>\n";
		if(!$result_exists)
		{
			$result_exists = true;
		}
	}
	
	if(!$result_exists)
	{
		echo "Aucune catégorie n'existe.";
	}
}

function options_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$texte_options = $texte_options . ' <option value=' . $row['id'] . '">' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}

if(isset($_POST['category']))
{
	$message_user = create_new_cateogry($_POST['category'], $pdo);
}
else if(isset($_GET['delete_id']))
{
	$message_user = delete_category($_GET['delete_id'], $pdo);
}
?>