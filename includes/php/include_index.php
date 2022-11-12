<?php

function show_completed_tasks_value()
{
	if (isset($_GET['show_complete_tasks'])) {
		$get_value = ($_GET['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		new_cookiee('show_complete_tasks', $get_value);
		return ($get_value == SHOW_COMPLETED_TASKS) ? true : false;
	}

	if (isset($_COOKIE['show_complete_tasks'])) {
		$cookie_value = ($_COOKIE['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		new_cookiee('show_complete_tasks', $cookie_value);
		return ($cookie_value == SHOW_COMPLETED_TASKS) ? true : false;
	}

	return new_cookiee('show_complete_tasks', SHOW_COMPLETED_TASKS);
}


function update_cookie_asc()
{
	if (isset($_GET['ASC'])) {
		$asc_cookie_value = $_GET['ASC'] == 'ASC' ? 'DESC' : 'ASC';
		return new_cookiee('ASC', $asc_cookie_value);
	}

	if (isset($_COOKIE['ASC'])) {
		$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'ASC' : 'DESC';
		return new_cookiee('ASC', 'ASC');
	}

	new_cookiee('ASC', 'ASC');
}

update_cookie_asc();

# EDIT
TasksConst::$show_completed_tasks = show_completed_tasks_value();
TasksConst::$get_arg_complete = TasksConst::$show_completed_tasks ? 0 : 1;
TasksConst::$str_complete = TasksConst::$show_completed_tasks ? 'Masquer' : 'Afficher';
TasksConst::$where_complete = TasksConst::$show_completed_tasks ? 'taches.complete IN("0","1")' : 'taches.complete = "0"';
TasksConst::$id_membre = isset($_SESSION['id']) ? $_SESSION['id'] : '';
TasksConst::$comparaison_date = comparaison_date(); # Constante de classe


function text_category_list($id = NULL)
{
	$pdo = monSQL::getPdo();
	$text = '';

	$sql = 'SELECT id, categorie FROM categories WHERE id_membre = ' . $_SESSION['id'];
	$statement = $pdo->prepare($sql);
	$statement->execute();
	return $statement;
}

function define_key_order()
{
	print_r($_GET);
	if (isset($_GET['orderby']))
		return array_key_exists($_GET['orderby'], ARRAY_ORDER_BY_TACHES) ? $_GET['orderby'] : DEFAULT_ORDER_TASKS;
	return DEFAULT_ORDER_TASKS;
}

function category_not_exists()
{
	$pdo = monSQL::getPdo();
	$sql = 'SELECT id FROM categories WHERE categorie = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute($_GET['categorie']);
}



function select_rows_taches($order_by, $sql_bind)
{
	$pdo = monSQL::getPdo(); # EDIT RAPIDLY

	$sql = 'SELECT taches.*,
	DATE_FORMAT(taches.date,"%d/%m/%Y") AS `french_date`,
	categories.categorie FROM taches 
	LEFT JOIN categories 
	ON categories.id = taches.id_categorie 
	WHERE taches.id_membre = ' . $_SESSION['id']
		. ' AND ' . TasksConst::$where_complete . '
	GROUP BY taches.id
	ORDER BY ' . $order_by . ' ' . $_COOKIE['ASC'];
	$sth = $pdo->prepare($sql);
	$sth->execute($sql_bind);
	return $sth->fetchAll();
}

function fetch_list_taches()
{
	$key_order = define_key_order();
	$order_by = ARRAY_ORDER_BY_TACHES[$key_order];
	$sql_bind = [];
	print($key_order);
	$rows_taches = select_rows_taches($order_by, $sql_bind);
	return $rows_taches;
}

function comparaison_date()
{
	if ($_COOKIE['ASC'] === 'DESC')
		return FAR_FAR_AWAY_DATE; // date "infinite"
	return TIMESTAMP_ZERO;
}

function data_importance_image($actual)
{
	$data_image = [];
	if (!in_array($actual, range(MIN_IMPORTANCE_TASKS, MAX_IMPORTANCE_TASKS)))
		$actual = MIN_IMPORTANCE_TASKS;

	$data_image['link'] = 'img/im' . str_repeat("p", $actual) . '.png';
	$data_image['alt'] = str_repeat('très', $actual - 1) . ' important';
	return $data_image;
}

function is_reference_date_updatable($date)
{
	if (
		$_GET['orderby'] === 'date'
		and (
			# EDIT
			($_COOKIE['ASC'] === 'ASC' and strtotime(substr($date, 0, 10)) > strtotime(substr(TasksConst::$comparaison_date, 0, 10)))
			or ($_COOKIE['ASC'] === 'DESC' and strtotime(substr($date, 0, 10)) < strtotime(substr(TasksConst::$comparaison_date, 0, 10)))
		)
	)
		return true;
	return false;
}

function update_reference_date($date) # EDIT + Skip a table to create another one if new date !!
{
	$text = '';
	if (is_reference_date_updatable($date)) {
		$comparaison_date = $date;
		$date_fr = strftime("%A %e %B %Y", strtotime($comparaison_date)); # EDITER
		$text = '<td colspan="7" class="termine_tache">Tâches du ' . $date_fr . '</td></tr>';
	}

	return [$comparaison_date, $date_fr, $text];
}
