<?php
if(!connecte())
{
	header('Location: index.php');
	exit();
}
$action_change_categorie = '';

$action_formulaire = 'Créer une tâche';
$description_categories = '';
$get_link = '';
$error_message = '';
$texte_nom_cat = '';

$nom_tache = '';
$date_tache = date("Y-m-d");
$d_rappel_tache = date("Y-m-d");
$id_categorie = '';
$description = '';
$complete = "1";
$importance = MIN_IMPORTANCE_TASKS;
$input_hidden = '<input type="hidden" name="nouvelle_tache" />';

$select_options_categories = '';

function input_importance($current_importance)
{
	$text = '';
	$importance_equals_default = ($current_importance == MIN_IMPORTANCE_TASKS);
	for ($importance = MIN_IMPORTANCE_TASKS; $importance <= MAX_IMPORTANCE_TASKS; $importance++) {
		$checked = '';
		if ($importance === $current_importance) # EDIT to default check depending on POST importance value
		{
			$checked = 'checked';
		}
		$text .= '<img src="img/im' . str_repeat("p", $importance) . '.png" alt="' . str_repeat('très', $importance - 1) . ' important"/> <input id="importance" type="radio" name="importance" value="' . $importance . '" ' . $checked . '/> ';
	}
	return $text;
}

function select_row_tache($pdo, $id)
{
	$query= 'SELECT * FROM taches WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($query);
	$statement->execute([$id, $_SESSION['id']]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function format_insert_post()
{
	$_POST['d_rappel_tache'] = substr($_POST['d_rappel_tache'], 0, 10); # EDIT
	$_POST['date_tache'] = substr($_POST['date_tache'], 0, 10); # EDIT
}

function insert_form_not_specified()
{
	return !array_key_exists('id_categorie', $_POST)
		or !array_key_exists('nom_tache', $_POST)
		or !array_key_exists('date_tache', $_POST)
		or !array_key_exists('id_categorie', $_POST);
}

function create_form_is_empty()
{
	$_POST = array_map('trim', $_POST);

	return empty($_POST['nom_tache'])
		or empty($_POST['date_tache'])
		or empty($_POST['id_categorie'])
		or empty($_POST['d_rappel_tache']);
}

function category_dont_exist($pdo)
{
	$sql_query = 'SELECT COUNT(*) FROM categories'
		.  ' WHERE categories.id =  ? AND id_membre = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_POST['id_categorie'], $_SESSION['id']]);
	$number_categories = $statement->fetchColumn();
	return ($number_categories !== 1);
}

function tache_exists($id)
{
	global $pdo;
	$sql_query = 'SELECT COUNT(*) FROM taches
	WHERE taches.id =  ? AND id_membre = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$id, $_SESSION['id']]);
	$number_categories = $statement->fetchColumn();
	return ($number_categories == 1);
}

function complete_status($id_tache)
{
	global $pdo;
	$sql = 'SELECT complete FROM taches WHERE id = ' . $id_tache;
	$res = $pdo->query($sql);
	$complete = $res->fetchAll();
	return $complete[0]['complete'];

}

function modify_taches_complete($id_tache)
{
	global $pdo;
	$complete = abs(complete_status($id_tache)-1);
	
	$sql = 'UPDATE taches SET complete=' . $complete . '
	WHERE id=' . $id_tache;

	$pdo->query($sql);
	exit();
}


function double_already_exists($pdo, $old_task)
{
	$tache_id_clause = '';
	$sql_arguments = [$_POST['id_categorie'], $_POST['nom_tache']];
	if($old_task)
	{
		$sql_arguments = array_merge($sql_arguments, [$_GET['editer']]);
		$tache_id_clause = 'AND taches.id != ?';
	}
	$sql_query = 'SELECT COUNT(*) FROM taches 
	WHERE taches.id_categorie = ? AND taches.nom_tache = ? ' . $tache_id_clause;

	$statement = $pdo->prepare($sql_query);
	$statement->execute($sql_arguments);

	$number_double_taches = $statement->fetchColumn();
	
	return ($number_double_taches > 0);
}

function form_not_specified()
{
	return !isset($_POST['id_categorie']) or !isset($_POST['nom_tache']);
}

function double_does_exist($pdo)
{
	$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id != ?'
		. ' AND taches.id_categorie = ?'
		. ' AND taches.nom_tache = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_GET['editer'], $_POST['id_categorie'], $_POST['nom_tache']]);

	$nb_double_taches = $statement->fetchColumn();
	return ($nb_double_taches == 0);
}


function date_or_remind_are_invalid()
{
	if (
		!preg_match(REGEX_VALID_TASKDATE, $_POST['d_rappel_tache'])
		or !preg_match(REGEX_VALID_TASKDATE, $_POST['date_tache'])
	)
		return true;
	return false;
}

function insert_data_task($pdo)
{
	$sql = "INSERT INTO taches
	(id, id_membre, id_categorie, nom_tache, description, date, rappel, importance) 
	VALUES (?,?,?,?,?,?,?,?)";

	$statement = $pdo->prepare($sql);
	$statement->execute([NULL, $_SESSION['id'], 
	$_POST['id_categorie'], $_POST['nom_tache'], 
	$_POST['description'], $_POST['date_tache'], 
	$_POST['d_rappel_tache'], $_POST['importance']]);
	return 'Nouvelle tâche envoyée avec succès';
}

function task_dosent_exist($pdo, $id)
{
	$query = 'SELECT COUNT(*) FROM taches 
	WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($query);

	$statement->execute([intval($id), $_SESSION['id']]);
	$number_double = $statement->fetchColumn();
	return ($number_double === 0);
}

function category_doesnt_exist($pdo, $id)
{
	$query = 'SELECT COUNT(*) FROM categories WHERE id = ?';
	$statement = $pdo->prepare($query);
	$statement->execute([$id]);
	$number_double = $statement->fetchColumn();
	return ($number_double == 0);
}

function set_default_values()
{
	$_POST['complete'] = !isset($_POST['complete']) ?  TASK_NOT_COMPLETED : $_POST['complete'];

	$valid_post_importance = isset($_POST['importance']) and in_array($_POST['importance'], range(1, 3)); # EDIT
	$_POST['importance'] = $valid_post_importance ? $_POST['importance'] : MIN_IMPORTANCE_TASKS;
}


function insert_new_task($pdo)
{
	format_insert_post();

	if (insert_form_not_specified())
		return 'Le formulaire est mal spécifié.';
	if (create_form_is_empty())
		return 'Vous n\'avez pas rempli le formulaire.';
	if (date_or_remind_are_invalid())
		return 'La date entrée est dans un format incorrect.<br />';
	if (category_dont_exist($pdo))
		return "La catégorie de la tâche est mal spéciifé.";
	if (double_already_exists($pdo, false))
		return 'Une tâche a déjà un nom identique à ce que vous voulez créer dans la catégorie courante.';

	set_default_values();
	insert_data_task($pdo);

	# header('Location: taches.php');
}

function check_update_tache($pdo)
{
	if (task_dosent_exist($pdo, $_GET['editer']))
		return 'La tâche à éditer n\'existe pas.';
	if (category_doesnt_exist($pdo, $_POST['id_categorie']))
		return 'La catégorie de la tâche à éditer n\'existe pas.';
	if (double_already_exists($pdo, true)) # EDIT 
		return 'Un doubleon de cette t$ache existe déjà dans la catégorie à éditer.';
	format_insert_post();
	if (date_or_remind_are_invalid())
		return 'La date entrée est dans un format incorrect.<br />';
	set_default_values();
	return false;
}

function update_tache($pdo)
{
	$sql = 'UPDATE taches
	SET id_categorie = ?, nom_tache = ?, description = ?,  date = ?,
	importance = ?, complete = ?, rappel = ? 
	WHERE id = ? AND id_membre = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute(
		[ # DIT
			$_POST['id_categorie'],
			$_POST['nom_tache'],
			$_POST['description'],
			$_POST['date_tache'],
			$_POST['importance'],
			$_POST['complete'],
			$_POST['d_rappel_tache'],
			$_GET['editer'],
			$_SESSION['id']
		]
	);
	$_POST['nom_tache'] = htmlentities($_POST['nom_tache']);
	return "Tâche {$_POST['nom_tache']} modifiée avec succès";
}

function update_status($pdo)
{
	if (task_dosent_exist($pdo, $_GET['complete']))
		return 'Le status de la tâche a été modifié avec succès.';

	$sql = "UPDATE taches SET complete = ABS(complete-1) WHERE id = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['complete']]);
	return 'La tâche à modifier n\'existe pas.';
}


function delete_tache($pdo, $id)
{
	if (task_dosent_exist($pdo, $id))
		return 'La tâche à supprimer n\'eixste pas.';

	$sql = "DELETE FROM taches WHERE id = ? AND id_membre = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['supprimer'], $_SESSION['id']]);
	return 'La tâche avec le nom a été supprimé.';
}

function make_categories_list($int_selected_category = '')
{
	global $pdo;
	$sql = "SELECT id, categorie FROM categories WHERE id_membre = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$_SESSION['id']]);
	
	$texte_options = '';
	$selected = '';
	while ($row = $statement->fetch()) {
		if (isset($_GET['id_categorie']) AND intval($_GET['id_categorie']) === $row['id']) {
			$selected = 'selected';
		}

		$texte_options .=  
		' <option value="' . intval($row['id']) . '" ' . 
		$selected . '>' . $row['categorie'] . '</option>';
	} # MVC
	return $texte_options;
}

function html_options_categories_list($pdo, $id_task = '') # MVC + EDIT ??
{
	$id_cat = '';
	$result_exists = false;

	$statement = $pdo->query('SELECT id, categorie FROM categories');

	$statement_bis = $pdo->prepare('SELECT id_categorie FROM taches WHERE id = ?');
	$statement_bis->execute([$id_task]);
	$nb_tasks = $statement_bis->rowCount();
	if ($nb_tasks === 1) {
		$row_tasks = $statement_bis->fetch();
		$id_cat = $row_tasks['id_categorie'];
	}

	$texte_options = '';
	while ($row = $statement->fetch()) {
		$selected = '';
		if ($id_cat === $row['id']) {
			$selected = 'selected';
		}
		$texte_options = $texte_options . ' <option  value="' . intval($row['id']) . '"'
			. $selected . '>'
			. htmlentities($row['categorie'])
			. '</option>';
	}
	return $texte_options;
}

function show_tasks_of_category($pdo, $category) # MVC
{
	$txt_taches_cat = '<table>';
	$txt_taches_cat .=
		'<tr>
		<td>ID</td>
		<td><b>Nom</b></td>
		<td>description</td>
		<td>date</td>
		<td>E</td>
		<td>X</td>
	</tr>';

	$sql = 'SELECT id, nom_tache, description, date, id_categorie, importance 
	FROM taches WHERE id_categorie = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$category]);
	$table_taches = $statement->fetchAll();

	foreach ($table_taches as $row) {
		extract($row); # MVC
		$txt_taches_cat .= '<tr>
			<td class="titre_tache">
			' . $id . '
			</td>
			<td class="titre_tache">
			' . htmlentities($nom_tache) . '
			</td>
			<td class="titre_tache">
			' . htmlentities($description) . '
			</td>
			<td class="titre_tache">
			' . $date . '
			</td>
			<td>
				<a href="taches.php?editer=' . $id . '&id_categorie=' . $id_categorie . '">E</a>
			</td>' . PHP_EOL . '
			<td>
				<a href="taches.php?supprimer=' . $id . '">X</a>
			</td>' . PHP_EOL;
	}

	$txt_taches_cat .= '</table>';
	return $txt_taches_cat;
}

if(isset($_GET['complete']))
{
	if(tache_exists($_GET['complete']))
	{
		modify_taches_complete($_GET['complete']);
		exit();
		
	}
	else # pas ici
	{
		echo 'non';
		exit();
		$error_message = 'La tâche à supprimer n\'existe pas.';
	}
	
}


if (isset($_POST['nouvelle_tache'])) # EDIT
{
	$error_message = insert_new_task($pdo);

	$id_categorie = htmlentities($_POST['id_categorie']);
	$nom_tache = htmlentities($_POST['nom_tache']);
	$date_tache = htmlentities($_POST['date_tache']);
}

if (isset($_GET['id_categorie']) and $_GET['id_categorie'] !== "") # EDIT
{
	$id_categorie = $_GET['id_categorie'];
	$sql = 'SELECT COUNT(categorie) FROM categories WHERE categories.id = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$id_categorie]);

	$nb_cat_id = $statement->fetchColumn();

	if ($nb_cat_id === 1) {
		$texte_nom_cat = 'Tâches de la catégorie';
		$description_categories = show_tasks_of_category($pdo, $id_categorie);
	} else {
		$texte_nom_cat = "La catégoriede numéro $id_categorie n'existe pas.";
	}
} else {
	$texte_nom_cat = 'Veuillez séléctionnet une catégorie';
}

if (isset($_POST['editer_tache']) and isset($_GET['editer'])) # EDIT
{
	$error_message = check_update_tache($pdo);
	if ($error_message === false)
		$error_message = update_tache($pdo);
}

if (isset($_GET['editer'])) # EDIT
{

	if(!task_dosent_exist($pdo, $_GET['editer'])) {
		$tache = select_row_tache($pdo, $_GET['editer']);
		extract($tache);
		$complete = ($complete === 1) ? 'checked' : '';

		$date_tache = substr($date, 0, 10);
		$d_rappel_tache = substr($rappel, 0, 10);
		$date_tache = substr($date, 0, 10);

		$action_formulaire = 'Éditer la tâche : <i>"' . htmlentities($nom_tache) . '</i>"';
		$input_hidden = '<input type="hidden" name="editer_tache" />';

		$get_link = make_stripped_get_args_link([], ['editer' => $_GET['editer'], 'id_categorie' => $id_categorie]);
	}
	$select_options_categories =  make_categories_list();
} elseif (isset($_GET['id_categorie'])) {
	$select_options_categories = make_categories_list($pdo, $_GET['id_categorie']);
} else {
	$select_options_categories = make_categories_list($pdo);
}

