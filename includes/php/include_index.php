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
	if (isset($_GET['order_by'])) {
		$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'DESC' : 'ASC';
		return new_cookiee('ASC', $asc_cookie_value);
	}
	if (!isset($_COOKIE['ASC']))
		return new_cookiee('ASC', 'ASC');
	$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'ASC' : 'DESC';
	new_cookiee('ASC', $asc_cookie_value);
}

update_cookie_asc();

# SET PUBLIC STATIC VARIABLES 
TasksConst::$show_completed_tasks = show_completed_tasks_value();
TasksConst::$get_arg_complete = TasksConst::$show_completed_tasks ? 0 : 1;
TasksConst::$str_complete = TasksConst::$show_completed_tasks ? 'Masquer' : 'Afficher';
TasksConst::$where_complete = TasksConst::$show_completed_tasks ? 'taches.complete IN("0","1")' : 'taches.complete = "0"';
TasksConst::$id_membre = isset($_SESSION['id']) ? $_SESSION['id'] : '';

function text_category_list($id = NULL) # EDIT MVC (créer une vue)
{
	$pdo = monSQL::getPdo();
	$text = '';

	$sql = 'SELECT id, categorie FROM categories';
	$statement = $pdo->prepare($sql);
	$statement->execute();
	return $statement;
}

function define_key_order()
{
	if (isset($_GET['order_by']))
		return array_key_exists($_GET['order_by'], ARRAY_ORDER_BY_TACHES) ? $_GET['order_by'] : DEFAULT_ORDER_TASKS;
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

	$rows_taches = select_rows_taches($order_by, $sql_bind);
	return $rows_taches;
}

function comparaison_date()
{
	if ($_COOKIE['ASC'] === 'DESC') 
		return FAR_FAR_AWAY_DATE; // date "infinite"
	return TIMESTAMP_ZERO;
}

function barrer_tache($row)
{

	if ($row['complete'] === 1)
		return 'class="barrer"';
	return  '';
}

function generate_importance($actual_importance)
{
	$txt_importance = '';
	$importance = MIN_IMPORTANCE_TASKS;
	while($importance <= MAX_IMPORTANCE_TASKS) {
		if (($importance === MIN_IMPORTANCE_TASKS
				and !in_array($actual_importance, range(1, 3)))
			or $importance === $actual_importance
		) {
			$txt_importance = '<img src="img/im' . str_repeat("p", $importance)
				. '.png" alt="' . str_repeat('très', $importance - 1)
				. ' important"/>';
		}
		$importance++;
	}
	return $txt_importance;
}

function select_list_taches() # EDIT pour code propre !!!
{
	$pdo = monSQL::getPdo();

	$comparaison_date = comparaison_date(); # Constante de classe
	$rows_taches = fetch_list_taches();

	$html_text_taches = ''; 
	foreach ($rows_taches as $row) {
		$class_s = barrer_tache($row);

		# EDIT - Créer un efonction pour synthétiser cette grosse condition !
		if (isset($_GET['order_by'])) {
			if (
				$_GET['order_by'] === 'date'
				and (
					# EDIT
					($_COOKIE['ASC'] === 'ASC' and strtotime(substr($row['date'], 0, 10)) > strtotime(substr($comparaison_date, 0, 10)))
					or ($_COOKIE['ASC'] === 'DESC' and strtotime(substr($row['date'], 0, 10)) < strtotime(substr($comparaison_date, 0, 10)))
				)
			) {
				$comparaison_date = $row['date'];
				$date_fr = strftime("%A %e %B %Y", strtotime($comparaison_date)); # EDITER
				$html_text_taches .= '<td colspan="7" class="termine_tache">Tâches du ' . $date_fr . '</td></tr>';
			}
		}
		
		# mettre ce code dans du HTML !!!
		$html_text_taches .= '<tr>' . PHP_EOL
			. '<td>' . $row['id'] . '</td>' . PHP_EOL
			. '<td id="titre_tache' . $row['id'] . '" ' . $class_s . '>' . htmlentities($row['nom_tache']) .  '</td>'
			. PHP_EOL . '<td>' . htmlentities($row['categorie']) . '</td>' . PHP_EOL
			. '<td class="description">' . htmlentities($row['description']) . '</td>' . PHP_EOL
			. '<td class="importance">';

		$html_text_taches .= generate_importance($row['importance']);

		$checked_termine =  ($row['complete'] === 1) ? 'checked' : '';

		# mettre ce code dans du HTML !!!
		$html_text_taches .= '</td>' . PHP_EOL
			. '<td>' . $row['date'] . '</td>' . PHP_EOL
			. '<td class="termine_tache"><input type="checkbox" id="termine'
			. strval($row['id']) . '" onclick="BarrerTexte(' . $row['id'] . ')"'
			. $checked_termine . '/></td>' . PHP_EOL
			. '</tr>' . PHP_EOL;
	}
	return $html_text_taches;
}

$liste_categorie = text_category_list();
