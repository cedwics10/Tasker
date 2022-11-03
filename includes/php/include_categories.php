<?php
if (!connecte()) {
	header('Location: index.php');
	exit();
}

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
	if ((strlen($categorie_name) < MIN_LENGTH_CATEGORY_NAME) or (strlen($categorie_name) < MIN_LENGTH_CATEGORY_NAME))
		return true;
	return false;
}

function not_members_category()
{
	global $pdo; # editer
	$sql = 'SELECT categorie, id_membre FROM categories WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['editer'], $_SESSION['id']]);
	$data_member = $statement->fetchAll();
	return (count($data_member) === 0);
}


function update_category_name($pdo)
{
	if (!isset($_GET['editer']) or !isset($_POST['category_editer'])) {
		return 'Le formulaire est mal spécifié.';
	}

	$sql = 'SELECT categorie, id_membre FROM categories 
	WHERE id = ? AND categorie = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['editer'], $_POST['category_editer'], $_SESSION['id']]);
	$number_of_categories = $statement->rowCount();

	if ($number_of_categories !== 0)
		return 'Cette catégorie existe déjà.';

	if (not_members_category($statement))
		return 'une erreur imprévue est arrivée';

	if (category_length_not_ok($_POST['category_editer'])) {
		return 'La longueur du titre de la catégorie doit être compris entre 3 et 100 caractères';
	}

	$sql = 'UPDATE categories SET categorie = ? 
	WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute(
		[
			$_POST['category_editer'],
			$_GET['editer'],
			$_SESSION['id']
		]
	);

	return '';
}


function double_category_exists($categorie)
{
	global $pdo; # EDIT
	$message_user = '';
	$sql = 'SELECT COUNT(*) FROM categories 
	WHERE categories.categorie = "' . $categorie . '"';
	$res = $pdo->query($sql);
	$number_of_double = $res->fetchColumn();
	return ($number_of_double > 0);
}

function create_new_cateogry($categorie, $pdo)
{
	if (double_category_exists($categorie)) {
		return  '<b>Cette catégorie a déjà été créée !</b>';
	}

	if (category_length_not_ok($categorie)) {
		return  '<b>Le nom que vous avez choisi est trop court</b>';
	}

	$sql = 'INSERT INTO categories (categorie, id_membre) 
	VALUES (?,?)';
	$statement = $pdo->prepare($sql);
	$statement->execute([$categorie, $_SESSION['id']]);
	return "<b>La catégorie au nom de $categorie a été créé</b>";
}

function delete_from_category_tasks($id)
{
	if(!isset($_SESSION['id']))
		return false;
	global $pdo; # EDITER
	$sql = 'DELETE FROM taches 
	WHERE id_categorie = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$id, $_SESSION['id']]);

	$sql = 'DELETE FROM categories 
	WHERE categories.id = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$id, $_SESSION['id']]);
	return '<b>La catégorie a été supprimée avec succès.</b>';
}

function delete_category($id, $pdo)
{
	$sql = 'SELECT COUNT(*) FROM categories WHERE categories.id = ? AND categories.id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$id, $_SESSION['id']]);

	$number_of_match = $statement->fetchColumn();
	if ($number_of_match !== 1) {
		return '<b>La catégorie que vous voulez effacer n\'existe pas</b>';
	}

	delete_from_category_tasks($id);
}

function rows_categories($pdo)
{
	$result_exists = false;
	$sql = 'SELECT categories.id, categories.categorie, COUNT(taches.id)'
		. ' `nbTaches` FROM categories'
		. ' LEFT JOIN taches ON taches.id_categorie = categories.id'
		. ' LEFT JOIN membres ON membres.id = categories.id_membre'
		. ' WHERE membres.id = ?'
		. ' GROUP BY categories.id';
	$statement = $pdo->prepare($sql);
	$statement->execute([$_SESSION['id']]);
	return $statement;

	if (!$result_exists) {
		echo "Aucune catégorie n'existe.";
		return false;
	}
}

function make_categories_list($pdo)
{
	$statement = $pdo->query("SELECT id, categories.categorie FROM categories");
	$texte_options = '';
	while ($row = $statement->fetch()) {
		$texte_options = $texte_options . ' <option value=' . $row['id'] . '">' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}

if (isset($_POST['edit_category'])) {
	$message_user = update_category_name($pdo);
}

if (isset($_GET['editer'])) {
	$editer = '_editer';
	$sql = 'SELECT categorie FROM categories 
	WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['editer'], $_SESSION['id']]);
	$number_of_categories = $statement->rowCount();

	if ($number_of_categories === 1) {
		$form_usage = 'Editer';
		$editer_url = 'editer=' . $_GET['editer'];
		$f_category = $statement->fetchColumn();
		$hidden = '<input type="hidden" name="edit_category"/>';
	}
}

if (isset($_POST['category'])) {
	$message_user = create_new_cateogry($_POST['category'], $pdo);
} else if (isset($_GET['delete_id'])) {
	$message_user = delete_category($_GET['delete_id'], $pdo);
}
