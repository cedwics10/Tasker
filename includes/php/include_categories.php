<?php
# MVC !!!
$editer = '';
$editer_url = '';
$message_user = '';

$form_usage = 'Créer';
$cat_editer = '';

$f_category = '';
$edit = '';
$hidden = '';

function category_length_not_ok($categorie_name)
{
	if((strlen($categorie_name) < MIN_LENGTH_CATEGORY_NAME) or (strlen($categorie_name) < MIN_LENGTH_CATEGORY_NAME))
		return true;
	return false;
}

function update_category_name($pdo)
{
	if(!isset($_GET['editer']) or !isset($_POST['category_editer'])) {  
		return 'Le formulaire est mal spécifié.';
	}

	$sql_query = 'SELECT categorie FROM categories WHERE id = ? AND categorie = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_GET['editer'], $_POST['category_editer']]);
	$number_of_categories = $statement->rowCount();

	if($number_of_categories !== 0)
	{
		return 'Cette catégorie existe déjà.';
	}

	if(category_length_not_ok($_POST['category_editer']))
	{
		return 'La longueur du titre de la catégorie doit être compris entre 3 et 100 caractères';
	}

	$sql = 'UPDATE categories SET categorie = ? WHERE id = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute(
		[$_POST['category_editer'], 
		$_GET['editer']]
	);

	return '';
}

function create_new_cateogry($categorie, $pdo)
{
	$message_user = '';
	$sql_query = 'SELECT COUNT(*) FROM categories WHERE categories.categorie = "' . $categorie . '"';
	$res = $pdo->query($sql_query);
	$number_of_double = $res->fetchColumn();
	
	if($number_of_double !== 0)
	{
		return  '<b>Cette catégorie a déjà été créée !</b>';
	} 

	if(category_length_not_ok($categorie))
	{
		return  '<b>Le nom que vous avez choisi est trop court</b>';
	}

	$sql = 'INSERT INTO categories (categorie) VALUES (?)';
	$statement= $pdo->prepare($sql);
	$statement->execute([$categorie]);
	return "<b>La catégorie au nom de $categorie a été créé</b>";
}

function delete_category($id, $pdo)
{
	$sql = 'SELECT COUNT(*) FROM categories WHERE categories.id = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$id]);
	
	$number_of_match = $statement->fetchColumn();
	if($number_of_match  !== 1)
	{
		return '<b>La catégorie que vous voulez effacer n\'existe pas</b>';
	}

	$sql = 'DELETE FROM taches WHERE id_categorie = ?';
	$statement= $pdo->prepare($sql);
	$statement->execute([$id]);

	$sql_query = 'DELETE FROM categories WHERE categories.id = ?';
	$statement= $pdo->prepare($sql_query);
	$statement->execute([$id]);
	return '<b>La catégorie a été supprimée avec succès.</b>';
}

function show_categories($pdo)
{
	$result_exists = false;
	$statement = $pdo->query('SELECT categories.id, categories.categorie, COUNT(taches.id)' 
						. ' `nbTaches` FROM categories' 
						. ' LEFT JOIN taches ON taches.id_categorie = categories.id'
						. ' GROUP BY categories.id');
	while($row = $statement->fetch())
	{
		# EDIT with MVC
		echo "<tr>" . PHP_EOL 
		. "<td>" . $row['id'] . "</td>" . PHP_EOL 
		. "<td class='titre_tache'>" . htmlentities($row['categorie']) . "</td>" . PHP_EOL 
		. "<td class=''>" . $row['nbTaches'] . "</td>" . PHP_EOL
		. "<td><a href=\"categories.php?delete_id=" . $row['id'] . "\">X</a></td>" . PHP_EOL
		. "<td><a href=\"categories.php?editer=" . $row['id'] . "\">E</a></td>" . PHP_EOL
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

function make_categories_list($pdo)
{
	$statement = $pdo->query("SELECT id, categories.categorie FROM categories");
	$texte_options = '';
	while($row = $statement->fetch())
	{
		$texte_options = $texte_options . ' <option value=' . $row['id'] . '">' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}

if(isset($_POST['edit_category']))
{
	$message_user = update_category_name($pdo);
}

if(isset($_GET['editer']))
{ 
	$editer = '_editer';
	$sql_query = 'SELECT categorie FROM categories WHERE id = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_GET['editer']]);
	$number_of_categories=$statement->rowCount();

	if($number_of_categories === 1)
	{
		$form_usage = 'Editer';
		$editer_url = 'editer=' . $_GET['editer'];
		$f_category = $statement->fetchColumn();
		$hidden = '<input type="hidden" name="edit_category"/>';
	}
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