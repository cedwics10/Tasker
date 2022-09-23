<?php
$action_formulaire = 'Créer une tâche';
$desc_categories = '';
$get_link = '';
$texte_ht = '';


/* Form tâche */
$nom_tache = '';
$date_tache = '';
$d_rappel_tache = '';
$id_categorie = '';
$description = '---';
/* Form tâche */

$options_categories = '';

$input_hidden = '';


function options_categories($pdo, $slctd_cat = '')
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id, categorie FROM categories");
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$selected = '';
		if(isset($slctd_cat))
		{
			if($slctd_cat == $row['id'] )
			{
				$selected = 'selected="selected"';
			}
			
		}
		$texte_options = $texte_options . ' <option value="' . intval($row['id']) . '" ' . $selected . '>' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}

function show_tasks_of_gcat($pdo, $category)
{
	$txt_taches_cat = '<table>';
	$txt_taches_cat .= '<tr><td>ID</td><td><b>Nom</b></td><td>description</td><td>date</td><td>E</td><td>X</td></tr>';

	$sql = 'SELECT id, nom_tache, description, date FROM taches WHERE id_categorie = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$category]);
	$taches = $stmt->fetchAll();
		
	foreach ($taches as $row) {
		$txt_taches_cat .= '<tr>
			<td class="titre_tache">
			' . $row['id'] . '
			</td>
			<td class="titre_tache">
				' . $row['nom_tache'] . '
			</td>
			<td class="titre_tache">
			' . $row['description'] . '
			</td>
			<td class="titre_tache">
			' . $row['date'] . '
			</td>
			<td>
				<a href="taches.php?editer=' . $row['id']. '">E</a>
			</td>' . PHP_EOL . '
			<td>
				<a href="taches.php?supprimer=' . $row['id']. '">X</a>
			</td>' . PHP_EOL;
	}

	$txt_taches_cat .= '</table>';
	return $txt_taches_cat;
}


function e_task_opt_cat($pdo, $id_task = '')
{
	$id_cat = '';
	
	$result_exists = false;
	$stmt = $pdo->query("SELECT id, categorie FROM categories");
	
	$stmt_bis = $pdo->prepare("SELECT id_categorie FROM taches WHERE id = ?");
	$stmt_bis->execute([$id_task]);
	$nb_tasks = $stmt_bis->rowCount();
	if($nb_tasks == 1)
	{
		$row_tasks = $stmt_bis->fetch();
		$id_cat = $row_tasks['id_categorie'];
		print($id_cat);
	}
	
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$selected = '';
		if($id_cat == $row['id'] )
		{
			$selected = 'selected="selected"';
		}
		$texte_options = $texte_options . ' <option value="' . intval($row['id']) . '"' 
										. $selected . '>' 
										. $row['categorie'] 
										. '</option>';
	}
	return $texte_options;
}

if(isset($_POST['nouvelle_tache']))
{
	if(isset($_POST['id_categorie']) and isset($_POST['nom_tache']) and isset($_POST['date']))
	{
		$sql_query = 'SELECT COUNT(*) FROM categories WHERE categories.id = ' . intval($_POST['id_categorie']) . '';
		$res = $pdo->query($sql_query);
		$nb_cat_tache = $res->fetchColumn();
		
		if($nb_cat_tache == 1)
		{
			$sql_query = 'SELECT COUNT(*) FROM taches WHERE taches.id_categorie = ' . $_POST['id_categorie'] . ' AND taches.nom_tache = "' . $_POST['nom_tache'] .'"';
			$res = $pdo->query($sql_query);
			$nb_taches_idtq = $res->fetchColumn();

			if($nb_taches_idtq == 0)
			{
				if(preg_match("#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", $_POST['date']))
				{
					$sql = "INSERT INTO taches (id, id_categorie, nom_tache, description, date) VALUES (?, ?, ?,?,?)";
					$stmt= $pdo->prepare($sql);
					$stmt->execute(['', $_POST['id_categorie'], $_POST['nom_tache'], $_POST['description'], $_POST['date']]);
					$texte_ht = 'Nouvelle tâche envoyée avec succès';
				}
				else
				{
					$texte_ht = 'La date entrée est dans un format incorrect.<br />';
				}
			}
			else
			{
				$texte_ht = "Une tâche a déjà un nom identique à ce que vous voulez créer dans la catégorie courante de cette tâche.";
			}
		}
		else
		{
			$texte_ht = "La catégorie pour la tâche n'existe pas : $nb_cat_tache <br />";
		}
	}
	else
	{
		$texte_ht = 'Vous n\'avez pas rempli le formulaire.';
	}
}


if(isset($_GET['id_categorie']) and $_GET['id_categorie'] != "")
{
	$id_categorie = $_GET['id_categorie'];
	$sql = 'SELECT COUNT(categorie) FROM categories WHERE categories.id = ?';
	$stmt= $pdo->prepare($sql);
	$stmt->execute([$id_categorie]);
	
	$nb_cat_id = $stmt->fetchColumn();
	
	if($nb_cat_id == 1)
	{
		$texte_nom_cat = 'Tâches de la catégorie';
		$desc_categories = show_tasks_of_gcat($pdo, $id_categorie);
	}
	else
	{
		$texte_nom_cat = "La catégoriede numéro $id_categorie n'existe pas.";
	}
}
else
{
	$texte_nom_cat = '';
}

if(isset($_GET['editer']))
{
	$sql = 'SELECT id_categorie FROM taches WHERE id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_GET['editer']]);
	$count = $stmt->rowCount();

	if($count == 1)
	{
		$sql = 'SELECT * FROM taches WHERE id = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_GET['editer']]);
		$tache_a_editer = $stmt->fetch();
		extract($tache_a_editer);
		
		$date = substr($date,0,10);
		$d_rappel_tache = substr($d_rappel_tache,0,10);
	
		$action_formulaire = 'Éditer la tâche : <i>"' . $nom_tache . '</i>"';
		$input_hidden = '<input type="hidden" name="editer_tache" />';
		$get_link = '?editer=' . $_GET['editer'];
	}
}

if(isset($_POST['editer_tache']) and isset($_GET['editer']))
{
	$query = 'SELECT COUNT(*) FROM taches WHERE id = ?';
	$stmt = $pdo->prepare($query);
	$stmt->execute([$_GET['editer']]);
	$nb_taches = $stmt->fetchColumn();
	if($nb_taches == 1)
	{
		$texte_nom_cat = 'La tâche à éditer eixte.';
	}
	else
	{
		$texte_nom_cat = 'La tâche à éditer n\'existe pas.';
	}
}

if(isset($_GET['editer']))
{
	$options_categories =  e_task_opt_cat($pdo, $_GET['editer']);
	// $desc_categories = show_tasks_of_gcat($pdo, $id_categorie);
}
elseif(isset($_GET['id_categorie']))
{
	$options_categories = options_categories($pdo, $_GET['id_categorie']);
}
else
{
	$options_categories = options_categories($pdo);

}
?>