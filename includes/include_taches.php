<?php 
function options_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$texte_options = $texte_options . ' <option value="' . $row['id'] . '">' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}



if(isset($_POST['nouvelle_tache']))
{
	if(isset($_POST['categorie_parcourir']) and isset($_POST['nom_tache']) and isset($_POST['date']))
	{
		$sql_query = 'SELECT categories.* FROM categories WHERE categories.categorie = ' . $_POST['categorie_parcourir'] . '';
		$res = $pdo->query($sql_query);
		$nb_cat_tache = $res->fetchColumn();
		if($nb_cat_tache == 1)
		{
			$sql_query = 'SELECT COUNT(taches.*) FROM taches WHERE  taches.id_categorie = ' . $_POST['categorie_parcourir'] . ' AND taches.nom_tache = "' . $_POST['nom_tache'] .'"';
			$res = $pdo->query($sql_query);
			$nb_taches_idtq = $res->fetchColumn();
			if($nb_taches_idtq == 1)
			{
				if(preg_match("#^[0-9]{}-[0-9]{2}-[0-9]{4}$#", $_POST['date']))
				{
					print("date ok categorie ok titre ok");
				}
				else
				{
					print("La date entrée est incorrecte.<br />");
				}
			}
			else
			{
				print("Une tâche a déjà un nom identique à ce que vous voulez créer dans la catégorie courante de cette tâche.");
			}
		}
		else
		{
			print("La catégorie pour la tâche n'existe pas : $nb_taches_idtq <br />");
		}
	}
	else
	{
		print('Vous n\'avez pas rempli le formulaire.');
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