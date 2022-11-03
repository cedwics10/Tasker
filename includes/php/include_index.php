<?php
# Passer ce code en MVC !
$text_category_list = '';
$show_completed_tasks = false;
$where_complete = '';
$message_successful_signup = isset($_GET[SUCCESSFUL_SIGNUP]) ? 'Vous avez réussi votre inscription. Vous pouvez vous connecter <a href="connexion.php">Ici</a>' : '';

function show_completed_tasks_value()
{
	if(isset($_GET['show_complete_tasks']))
	{
		$get_value = ($_GET['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		new_cookiee('show_complete_tasks', $get_value);
		return ($get_value == SHOW_COMPLETED_TASKS) ? true : false;
	}

	if(isset($_COOKIE['show_complete_tasks']))
	{
		$cookie_value = ($_COOKIE['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		new_cookiee('show_complete_tasks', $cookie_value);
		return ($cookie_value == SHOW_COMPLETED_TASKS) ? true : false;
	}
	
	return new_cookiee('show_complete_tasks', SHOW_COMPLETED_TASKS);
}


function update_cookie_asc()
{
	if(isset($_GET['order_by']))
	{
		$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'DESC' : 'ASC';
		return new_cookiee('ASC', $asc_cookie_value );
	}
	if(!isset($_COOKIE['ASC']))
		return new_cookiee('ASC', 'ASC');
	$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'ASC' : 'DESC';
	new_cookiee('ASC', $asc_cookie_value);	
}

update_cookie_asc();

# SET PUBLIC STATIC VARIABLES 
TasksConst::$show_completed_tasks = show_completed_tasks_value();
TasksConst::$get_arg_complete = ($_COOKIE['show_complete_tasks'] === SHOW_COMPLETED_TASKS) ? 0 : 1;
TasksConst::$str_complete = ($_COOKIE['show_complete_tasks'] === SHOW_COMPLETED_TASKS) ? 'Masquer' : 'Afficher';
TasksConst::$where_complete = ($_COOKIE['show_complete_tasks'] === SHOW_COMPLETED_TASKS) ? '' : 'complete != 1';
TasksConst::$id_membre = isset($_SESSION['id']) ? $_SESSION['id'] : '';

function text_category_list($pdo, $id = NULL) # EDIT MVC (créer une vue)
{
	$text = '';

	$sql = 'SELECT id, categorie FROM categories';
	$statement = $pdo->prepare($sql);
	$statement->execute();
	foreach($statement->fetchAll() AS $no => $fields_tache_row)
	{
		# MVC
		$text.= '<tr>
		<td>' . $fields_tache_row['id'] . '</td>
		<td>' . htmlentities($fields_tache_row['categorie']) . '</td>
		<td><a href="?categorie=' . $fields_tache_row['id'] . '">liste</a></td>
		</tr>';
	}

	return $text;
}

function define_key_order()
{
	if(isset($_GET['order_by']))
		return array_key_exists($_GET['order_by'], ARRAY_ORDER_BY_TACHES) ? $_GET['order_by'] : DEFAULT_ORDER_TASKS;
	return DEFAULT_ORDER_TASKS;
}

function category_not_exists($pdo)
{
	global $pdo;
	$sql = 'SELECT id FROM categories WHERE categorie = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute($_GET['categorie']);

}

# EDIT
function where_selected_taches()
{	

	if(TasksConst::$where_complete)
		return 'WHERE complete != 1';
	return '';
}

function select_rows_taches($where, $order_by, $sql_bind)
{
	global $pdo; # EDIT RAPIDLY

	$sql_query = 'SELECT taches.*,' 
	. 'DATE_FORMAT(taches.date,"%d/%m/%Y") AS `french_date`,' 
	. 'categories.categorie FROM taches '
	. 'LEFT JOIN categories '
	. 'ON categories.id = taches.id_categorie '
	. 'WHERE taches.id_membre = ' . $_SESSION['id'] . ' '
	. 'GROUP BY taches.id '
	. 'ORDER BY ' . $order_by . ' ' . $_COOKIE['ASC'];
    $sth = $pdo->prepare($sql_query);
	$sth->execute($sql_bind);
	return $sth->fetchAll();
}

function fetch_list_taches()
{
		
	$where = where_selected_taches();
	$key_order = define_key_order();
	$order_by = ARRAY_ORDER_BY_TACHES[$key_order];
	$sql_bind = [];

	$rows_taches = select_rows_taches($where, $order_by, $sql_bind);
	return $rows_taches;
}

function comparaison_date()
{
	
	if($_COOKIE['ASC'] === 'DESC')
	{
		return FAR_FAR_AWAY_DATE; // date "infinite"
 	}
	return TIMESTAMP_ZERO;
}

function barrer_tache($row)
{
	
	if($row['complete'] === 1)
	{
		return 'class="barrer"';
	}
	return  '';
}

function select_list_taches($pdo) # EDIT MVC (créer une vue)
{
	$comparaison_date = comparaison_date();
	$rows_taches = fetch_list_taches();

    $html_text_taches = '';
	foreach ($rows_taches as $fields_tache_row) {
	$class_s = barrer_tache($fields_tache_row);

		if(isset($_GET['order_by']))
		{
			if($_GET['order_by'] === 'date' 
				AND (
					($_COOKIE['ASC'] === 'ASC' AND strtotime(substr($fields_tache_row['date'],0,10)) > strtotime(substr($comparaison_date,0,10)))
					OR ($_COOKIE['ASC'] === 'DESC' AND strtotime(substr($fields_tache_row['date'],0,10)) < strtotime(substr($comparaison_date,0,10)))
				)
			)
			{
				$comparaison_date = $fields_tache_row['date'];
				$date_fr = strftime("%A %e %B %Y", strtotime($comparaison_date)); # EDITER
				$html_text_taches .= '<td colspan="7" class="termine_tache">Tâches du ' . $date_fr . '</td></tr>';

			}
		}
		# MVC
		$html_text_taches .= '<tr>' . PHP_EOL 
		. '<td>' . $fields_tache_row['id'].'</td>' . PHP_EOL 
		. '<td id="titre_tache' . $fields_tache_row['id'].'" ' . $class_s . '>' . htmlentities($fields_tache_row['nom_tache']).  '</td>' 
		. PHP_EOL . '<td>' .htmlentities($fields_tache_row['categorie']) . '</td>' . PHP_EOL 
		. '<td class="description">' . htmlentities($fields_tache_row['description']) . '</td>' . PHP_EOL
		. '<td class="importance">';

		for($importance = MIN_IMPORTANCE_TASKS; $importance<=MAX_IMPORTANCE_TASKS; $importance++)
		{
			if(($importance === MIN_IMPORTANCE_TASKS and !in_array($fields_tache_row['importance'], range(1,3))) or $importance === $fields_tache_row['importance'])
			{
				$html_text_taches .= '<img src="img/im' . str_repeat("p", $importance) . '.png" alt="' . str_repeat('très', $importance-1) . ' important"/>';
		
			}
		}
		
		$checked_termine = '';
		if($fields_tache_row['complete'] === 1)
			$checked_termine = 'checked';
		# MVC
		$html_text_taches .= '</td>' . PHP_EOL 
		. '<td>' . $fields_tache_row['date'] . '</td>' . PHP_EOL 
		. '<td class="termine_tache"><input type="checkbox" id="termine' 
		. strval($fields_tache_row['id']) . '" onclick="BarrerTexte(' . $fields_tache_row['id']. ')"'
		. $checked_termine . '/></td>' . PHP_EOL 
		. '</tr>' . PHP_EOL ;
	}
    return $html_text_taches;
}

$liste_categorie = text_category_list($pdo);
?>