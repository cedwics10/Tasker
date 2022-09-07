<?php 
function options_categories($pdo)
{
	$result_exists = false;
	$stmt = $pdo->query("SELECT id,categories.categorie FROM categories");
	$texte_options = '';
	while($row = $stmt->fetch())
	{
		$texte_options = $texte_options . ' <option value=' . $row['id'] . '">' . $row['categorie'] . '</option>';
	}
	return $texte_options;
}


if(isset($_GET['nom_categorie']))
{
	
}
else
{
	
}


if(isset($_POST['nouvelle_tache']))
{
	$sql_query = 'SELECT COUNT(*) FROM categories WHERE  categories.id = ' . $_POST['categorie_parcourir'] . '';
	$res = $pdo->query($sql_query);
	$nb_cat_tache = $res->fetchColumn();
	if($nb_cat_tache == 1)
	{
	$sql_query = 'SELECT COUNT(*) FROM taches WHERE  taches.id_categorie = ' . $_POST['categorie_parcourir'] . ' AND taches.nom_tache = "' . $_POST['nom_tache'] .'"';
		$res = $pdo->query($sql_query);
		$nb_categ_identiques = $res->fetchColumn();
		if($nb_categ_identiques == 0)
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
		print("La catégorie pour la tâche n'existe pas<br />");
	}
}

$options_categories = options_categories($pdo)
?>