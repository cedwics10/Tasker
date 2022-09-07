<?php 
require_once('includes/head.php');

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
<h1 style="text-align: center;">Créer et gérer vos tâches à faire</h1></br></br>
- Liste des tâches déjà créées <b>pour la catégorie {$_GET['nom_categorie']}
<form method="post" action="taches.php">
<select name="categorie_parcourir" id="categorie_parcourir">
    <option value="">Séléctionner une autre catégorie</option>
    <?php echo $options_categories; ?>
</select>
</form>
</b></br>
<hr />
Créer une nouvelle tâche :<br />
<form action="taches.php" method="post">
Nom de la tâche : <input type="text" name="nom_tache"/></br>
Jour de la réalisation de la tâche : <input type="date" name="date_limite"/></br>
Date rappel de la réalisation de la tâche (optioneel <input type="checkbox" name="date_rappel_ok"/> ) :  <input type="date" name="date_limite"/></br>
Catégorie de la tâche : <select name="categorie_parcourir" id="categorie_parcourir"></br>
    <option value="">Séléctionner une autre catégorie</option>
    <?php echo $options_categories; ?>
	</select>
	<input type="hidden" name="nouvelle_tache" value="envoyer"/>
	<input type="submit" name="envoyer" />
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>