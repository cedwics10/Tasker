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
		$cookie_value = ($_GET['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		nouveau_cookie('show_complete_tasks', $cookie_value);
		return ($_GET['show_complete_tasks'] == SHOW_COMPLETED_TASKS) ? true : false;
	}

	if(isset($_COOKIE['show_complete_tasks']))
	{
		$cookie_value = ($_COOKIE['show_complete_tasks'] == SHOW_COMPLETED_TASKS)  ? SHOW_COMPLETED_TASKS : HIDE_COMPLETED_TASKS;
		nouveau_cookie('show_complete_tasks', $cookie_value);
		return ($_COOKIE['show_complete_tasks'] == SHOW_COMPLETED_TASKS) ? true : false;
	}
	
	nouveau_cookie('show_complete_tasks', SHOW_COMPLETED_TASKS);
	return true;
}


function update_cookie_asc()
{
	if(isset($_GET['order_by']))
	{
		$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'DESC' : 'ASC';
		return nouveau_cookie('ASC', $asc_cookie_value );
	}
	if(!isset($_COOKIE['ASC']))
		return nouveau_cookie('ASC', 'ASC');
	$asc_cookie_value = $_COOKIE['ASC'] == 'ASC' ? 'ASC' : 'DESC';
	nouveau_cookie('ASC', $asc_cookie_value);	
}

update_cookie_asc();

# CREATE CLASS WITH THOSE CONSTANTS
TaskSconst::$show_completed_tasks = show_completed_tasks_value();
TasksConst::$get_arg_complete = ($show_completed_tasks) ? 0 : 1;
TaskSconst::$str_complete = ($show_completed_tasks) ? 'Masquer' : 'Afficher';
TaskSconst::$where_complete = ($show_completed_tasks) ? '' : 'complete != 1';

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

function select_list_taches($pdo) # EDIT MVC (créer une vue)
{
	global $where_complete;

	$sql_exec = [];
	$where = '';
	
	$key_order = 'nom';

	if(isset($_GET['order_by']))
	{
		if(array_key_exists($_GET['order_by'], ARRAY_ORDER_BY_TACHES))
		{
			$key_order = $_GET['order_by'];
		}
	}

	if(isset($_GET['categorie']))
	{
		if(is_numeric($_GET['categorie']))
		{
			$where = 'WHERE taches.id_categorie = ?';
			if($where_complete !== '')
			{
				$where .= ' AND ' . $where_complete;
			}
			$sql_exec[] = $_GET['categorie'];
		}
	}
	elseif($where_complete !== '')
	{
		$where = 'WHERE ' . $where_complete;
	}

	$order_by = ARRAY_ORDER_BY_TACHES[$key_order];

	# Stocker
	$sql_query = 'SELECT taches.*, DATE_FORMAT(taches.date,"%d/%m/%Y") AS `french_date`,' 
	. ' categories.categorie FROM taches'
	. ' LEFT JOIN categories'
	. ' ON categories.id = taches.id_categorie'
	. ' ' . $where
	. ' GROUP BY taches.id '
	. ' ORDER BY ' . $order_by . ' ' . $_COOKIE['ASC'];
	// print(nl2br($sql_query));
	// exit();
    $sth = $pdo->prepare($sql_query);
	$sth->execute($sql_exec);

	$taches = $sth->fetchAll();

    $html_text_taches = '';
	$current_date = '1970-01-01';
	if($_COOKIE['ASC'] === 'DESC')
	{
		$current_date = '2999-10-10'; // date "infinite"
 	}

	foreach ($taches as $fields_tache_row) {
		$class_s = "";
		if($fields_tache_row['complete'] === 1)
		{
			$class_s = 'class="barrer"';
		}

		if(isset($_GET['order_by']))
		{
			if($_GET['order_by'] === 'date' 
				AND (
					($_COOKIE['ASC'] === 'ASC' AND strtotime(substr($fields_tache_row['date'],0,10)) > strtotime(substr($current_date,0,10)))
					OR ($_COOKIE['ASC'] === 'DESC' AND strtotime(substr($fields_tache_row['date'],0,10)) < strtotime(substr($current_date,0,10)))
				)
			)
			{
				$current_date = $fields_tache_row['date'];
				$date_fr = strftime("%A %e %B %Y", strtotime($current_date));
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