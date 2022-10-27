<?php
$action_formulaire = 'Créer une tâche';
$desc_categories = '';
$get_link = '';
$edit_error_message = '';
$texte_nom_cat = '';

$nom_tache = '';
$date_tache = date("Y-m-d");
$d_rappel_tache = date("Y-m-d");
$id_categorie = '';
$description = '';
$complete = '';
$importance = strval(MIN_IMPORTANCE_TASKS);
$input_hidden = '<input type="hidden" name="nouvelle_tache" />';

$options_categories = '';


function make_categories_list($pdo, $str_selected_category = '')
{
	$statement = $pdo->query("SELECT id, categorie FROM categories");
	$texte_options = '';
	$selected = '';
	while($row = $statement->fetch())
	{
		if($str_selected_category === $row['id'] )
		{
			$selected = 'selected="selected"';
		}
		$texte_options = $texte_options . ' <option value="' . intval($row['id']) . '" ' . $selected . '>' . $row['categorie'] . '</option>';
	}	# MVC
	return $texte_options;
}

function show_tasks_of_category($pdo, $category) # MVC
{
	$txt_taches_cat = '<table>';
	$txt_taches_cat .= '<tr><td>ID</td><td><b>Nom</b></td><td>description</td><td>date</td><td>E</td><td>X</td></tr>';

	$sql = 'SELECT id, nom_tache, description, date, id_categorie, importance FROM taches WHERE id_categorie = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$category]);
	$table_taches = $statement->fetchAll();
		
	foreach ($table_taches as $row) {
		extract($row);
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


function html_options_categories_list($pdo, $id_task = '') # MVC + ???
{
	$id_cat = '';
	
	$result_exists = false;
	$statement = $pdo->query("SELECT id, categorie FROM categories");
	
	$statement_bis = $pdo->prepare("SELECT id_categorie FROM taches WHERE id = ?");
	$statement_bis->execute([$id_task]);
	$nb_tasks = $statement_bis->rowCount();
	if($nb_tasks === 1)
	{
		$row_tasks = $statement_bis->fetch();
		$id_cat = $row_tasks['id_categorie'];
	}
	
	$texte_options = '';
	while($row = $statement->fetch())
	{
		$selected = '';
		if($id_cat === $row['id'] )
		{
			$selected = 'selected';
		}
		$texte_options = $texte_options . ' <option  value="' . intval($row['id']) . '"' 
		. $selected . '>' 
		. htmlentities($row['categorie']) 
		. '</option>';
	}
	return $texte_options;
}

if(isset($_POST['nouvelle_tache']))
{
	if(isset($_POST['id_categorie']) 
		and isset($_POST['nom_tache']) 
		and isset($_POST['date_tache']))
	{
		$sql_query = 'SELECT COUNT(*) FROM categories' 
		.  ' WHERE categories.id =  ?';
		$statement = $pdo->prepare($sql_query);
		$statement->execute([$_POST['id_categorie']]);
		$nb_cat_tache = $statement->fetchColumn();
		
		if($nb_cat_tache === 1)
		{
			$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id_categorie = ' . $_POST['id_categorie'] . ' AND taches.nom_tache = "' . $_POST['nom_tache'] .'"';
			$res = $pdo->query($sql_query);
			$nb_taches_idtq = $res->fetchColumn();

			$_POST['d_rappel_tache'] = substr($_POST['d_rappel_tache'], 0, 10);
			$_POST['date_tache'] = substr($_POST['date_tache'], 0, 10);

			if($nb_taches_idtq === 0)
			{
				if(preg_match(REGEX_VALID_TASKDATE, $_POST['d_rappel_tache']) 
					AND preg_match(REGEX_VALID_TASKDATE, $_POST['date_tache'])
				)
				{
					$sql = "INSERT INTO taches (id, id_categorie, nom_tache, description, date, rappel) VALUES (?,?,?,?,?,?)";
					$statement= $pdo->prepare($sql);
					$statement->execute(['', $_POST['id_categorie'], $_POST['nom_tache'], $_POST['description'], $_POST['date_tache'], $_POST['date_tache']]);
					$edit_error_message = 'Nouvelle tâche envoyée avec succès';
				}
				else
				{
					$edit_error_message = 'La date entrée est dans un format incorrect.<br />';
				}
			}
			else
			{
				$edit_error_message = "Une tâche a déjà un nom identique à ce que vous voulez créer dans la catégorie courante de cette tâche.";
			}
		}
		else
		{
			$edit_error_message = "La catégorie pour la tâche n'existe pas : $nb_cat_tache <br />";
		}
	}
	else
	{
		$edit_error_message = 'Vous n\'avez pas rempli le formulaire.';
	}

	$id_categorie = htmlentities($_POST['id_categorie']);
	$nom_tache = htmlentities($_POST['nom_tache']);
	$dat_tache = htmlentities($_POST['date_tache']);

}


if(isset($_GET['id_categorie']) and $_GET['id_categorie'] !== "")
{
	$id_categorie = $_GET['id_categorie'];
	$sql = 'SELECT COUNT(categorie) FROM categories WHERE categories.id = ?';
	$statement= $pdo->prepare($sql);
	$statement->execute([$id_categorie]);
	
	$nb_cat_id = $statement->fetchColumn();
	
	if($nb_cat_id === 1)
	{
		$texte_nom_cat = 'Tâches de la catégorie';
		$desc_categories = show_tasks_of_category($pdo, $id_categorie);
	}
	else
	{
		$texte_nom_cat = "La catégoriede numéro $id_categorie n'existe pas.";
	}
}
else
{
	$texte_nom_cat = 'Veuillez séléctionnez une catégorie';
}

if(isset($_POST['editer_tache']) and isset($_GET['editer']))
{
	$query = 'SELECT COUNT(*) FROM taches WHERE id = ?';
	$statement = $pdo->prepare($query);
	$statement->execute([$_GET['editer']]);
	$nb_taches = $statement->fetchColumn();
	if($nb_taches === 1)
	{
		$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id !== ?' 
		. ' AND taches.id_categorie = ?'
		. ' AND taches.nom_tache = ?';
		$statement = $pdo->prepare($sql_query);
		$statement->execute([$_GET['editer'], $_POST['id_categorie'], $_POST['nom_tache']]);
		
		$nb_taches_idtq = $statement->fetchColumn();
		if($nb_taches_idtq === 0)
		{

			$_POST['d_rappel_tache'] = substr($_POST['d_rappel_tache'], 0, 10);
			$_POST['date_tache'] = substr($_POST['date_tache'], 0, 10);

			if(preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST['d_rappel_tache']) and preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST['date_tache']))
			{
				if(!isset($_POST['complete']))
				{
					$_POST['complete'] = TASK_NOT_COMPLETED;
				}

				if(!isset($_POST['importance']) or !in_array($_POST['importance'], range(1,3)))
				{
					$_POST['importance'] = MIN_IMPORTANCE_TASKS;
				}

				$sql = "UPDATE taches SET" 
				. " id_categorie = ?," 
				. " nom_tache = ?,"
				. " description = ?,"
				. " date = ?,"
				. " importance = ?,"
				. " complete = ?,"
				. "rappel = ?"
				. " WHERE id = ?";
				$statement= $pdo->prepare($sql);
				$statement->execute([
						$_POST['id_categorie'], 
						$_POST['nom_tache'], 
						$_POST['description'], 
						$_POST['date_tache'],
						$_POST['importance'],
						$_POST['complete'],
						$_POST['d_rappel_tache'],
						$_GET['editer']
					]
				);
				$edit_error_message = "Tâche \"{$_POST['nom_tache']}\" modifiée avec succès";
			}
			else
			{
				$edit_error_message = 'La date de la tâche à éditer est incorrecte.';
			}
		}
		else
		{
			$edit_error_message = 'La tâche à modifier a un nom identique à une autre tâche dans la catégorie X';
		}
	}
	else
	{
		$edit_error_message = 'La tâche à éditer n\'existe pas.';
	}
}

if(isset($_GET['supprimer']))
{
	$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_GET['supprimer']]);
	
	$count_name = $statement->fetchColumn();
	if($count_name === 1)
	{
		$sql = "DELETE FROM taches WHERE id = ?";
		$statement= $pdo->prepare($sql);
		$statement->execute([$_GET['supprimer']]);
		$edit_error_message = 'La tâche avec le nom a été supprimé.';
	}
	else
	{
		$edit_error_message = 'La tâche à supprimer n\'existe pas.';
	}
}

if(isset($_GET['complete']))
{
	$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id = ?';
	$statement = $pdo->prepare($sql_query);
	$statement->execute([$_GET['complete']]);
	
	$count_name = $statement->fetchColumn();
	if($count_name === 1)
	{
		$sql = "UPDATE taches SET complete = ABS(complete-1) WHERE id = ?";
		$statement= $pdo->prepare($sql);
		$statement->execute([$_GET['complete']]);
		$edit_error_message = 'Le status de la tâche a été modifié avec succès.';
	}
	else
	{
		$edit_error_message = 'La tâche à modifier n\'existe pas.';
	}
}


if(isset($_GET['editer']))
{

	$sql = 'SELECT complete, date, description, id_categorie, importance, nom_tache, rappel FROM taches WHERE id = ?';
	$statement = $pdo->prepare($sql);
	$statement->execute([$_GET['editer']]);
	$count = $statement->rowCount();

	if($count === 1)
	{
		$tache = $statement->fetch();
		extract($tache);
		$complete = ($complete === 1) ? 'checked' : '';

		$date_tache = substr($date,0,10);

		$d_rappel_tache = substr($rappel,0,10);
		$date_tache = substr($date,0,10);
		$action_formulaire = 'Éditer la tâche : <i>"' . htmlentities($nom_tache) . '</i>"';
		$input_hidden = '<input type="hidden" name="editer_tache" />';

		$get_link = '?editer=' . $_GET['editer'] . '&id_categorie=' . $id_categorie;
		print("L'importance est $importance");
	}

	$options_categories =  html_options_categories_list($pdo, $_GET['editer']);
	// $desc_categories = show_tasks_of_category($pdo, $id_categorie);
}
elseif(isset($_GET['id_categorie']))
{
	$options_categories = make_categories_list($pdo, $_GET['id_categorie']);
}
else
{
	$options_categories = make_categories_list($pdo);

}
