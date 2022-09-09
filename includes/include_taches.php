<?php 
function options_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$texte_options = $texte_options . ' <option value="' . intval($row['id']) . '">' . $row['categorie'] . '</option>';
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
					echo('Nouvelle tâche envoyée avec succès');
				}
				else
				{
					echo('La date entrée est dans un format incorrect.<br />');
				}
			}
			else
			{
				echo("Une tâche a déjà un nom identique à ce que vous voulez créer dans la catégorie courante de cette tâche.");
			}
		}
		else
		{
			echo("La catégorie pour la tâche n'existe pas : $nb_cat_tache <br />");
		}
	}
	else
	{
		echo('Vous n\'avez pas rempli le formulaire.');
		print_r($_POST);
	}
}

$options_categories = options_categories($pdo);

if(isset($_GET['nom_categorie']))
{
	$texte_nom_cat = 'Voici les tâches de la catégorie ' . $_GET['nom_categorie'];
}
else
{
	$texte_nom_cat = 'Séléctionnez une catégorie pour voir les tâches de celle-ci.';
}
?>