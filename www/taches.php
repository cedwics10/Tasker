<?php
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_taches.php');


$select_options_categories = isset($_GET['id_categorie']) ? make_categories_list($_GET['id_categorie']) : make_categories_list();

if(isset($_GET['complete']))
{
	if(tache_exists($_GET['complete']))
	{
		update_status($_GET['complete']);
		header('Location: index.php');
		exit();
	}
	else # pas ici
	{
		$error_message = 'La tâche à supprimer n\'existe pas.';
	}
	
}

if (isset($_POST['nouvelle_tache'])) # EDIT
{
	$error_message = insert_new_task();

	$id_categorie = htmlentities($_POST['id_categorie']);
	$nom_tache = htmlentities($_POST['nom_tache']);
	$date_tache = htmlentities($_POST['date_tache']);
}

if (isset($_GET['id_categorie']) and $_GET['id_categorie'] !== "") # EDIT
{
	$id_categorie = $_GET['id_categorie'];
	$sql = 'SELECT COUNT(categorie) FROM categories WHERE categories.id = ?';
	$statement = monSQL::getPdo()->prepare($sql);
	$statement->execute([$id_categorie]);

	$nb_cat_id = $statement->fetchColumn();

	if ($nb_cat_id === 1) {
		$texte_nom_cat = 'Tâches de la catégorie';
		$description_categories = show_tasks_of_category($id_categorie);
	} else {
		$texte_nom_cat = "La catégoriede numéro $id_categorie n'existe pas.";
	}
} else {
	$texte_nom_cat = 'Veuillez séléctionnet une catégorie';
}

if (isset($_POST['editer_tache']) and isset($_GET['editer'])) # EDIT
{
	$error_message = check_update_tache();
	if ($error_message === false)
		$error_message = update_tache();
}

if (isset($_GET['editer'])) # EDIT
{

	if(task_exists($_GET['editer'])) {

		$tache = select_row_tache($_GET['editer']);
		extract($tache);

		$complete = ($complete === 1) ? 'checked' : ''; # EDIT

		$date_tache = substr($date, 0, 10); # EDIT 
		$d_rappel_tache = substr($rappel, 0, 10); # EDIT
		$date_tache = substr($date, 0, 10);# EDIT

		$action_formulaire = 'Éditer la tâche : <i>"' . htmlentities($nom_tache) . '</i>"';
		$input_hidden = '<input type="hidden" name="editer_tache" />';

		$get_link = make_stripped_get_args_link([], ['editer' => $_GET['editer'], 'id_categorie' => $id_categorie]);
	}
	
}
?>

<?php # HTML
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>
<h3>Consulter/Editer des tâches de chaque catégorie:</h3>
<h4><?= $error_message ?></h4>

<form method="get" action="">
	<?php echo $texte_nom_cat ?>
	<select name="id_categorie" id="id_categorie" onChange="this.parentNode.submit()">
		<option value="">Séléctionner une autre catégorie</option>
		<?php echo $select_options_categories; ?>
	</select>
</form>
<?= $description_categories ?>
<hr />
<form action="taches.php<?= $get_link ?>" method="post">
	<table>
		<tr>
			<td><b><?= $action_formulaire ?></b></td>
			<td></td>
		</tr>

		<tr>
			<td>Nom de la tâche</td>
			<td><input type="text" name="nom_tache" value="<?= htmlentities($nom_tache) ?>" /></td>
		</tr>
		<tr>
			<td>Jour de la réalisation de la tâche</td>
			<td><input type="date" name="date_tache" id="date_tache" value="<?= $date_tache ?>" /></td>
		</tr>
		<tr>
			<td>Date de rappel (identique à la tâche <input type="checkbox" id="ch_rappel_tache" name="ch_rappel_tache" onclick="DateRappel()" /> ) :</td>
			<td><input type="date" name="d_rappel_tache" id="d_rappel_tache" value="<?= $d_rappel_tache ?>" /></td>
		</tr>
		<tr>
			<td>Catégorie de la tâche</td>
			<td>
				<select name="id_categorie" id="id_categorie">
					<option value="">Séléctionner une autre catégorie</option>
					<?php echo $select_options_categories; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Description de la tâche</td>
			<td><textarea id="description" name="description"><?= htmlentities($description) ?></textarea></td>
		</tr>
		<tr>
			<td>Importance de la tâche</td>
			<td>
				<?= make_input_importance($importance) ?>
			</td>
		</tr>
		<tr>
			<td>Terminé ?</td>
			<td><input type="checkbox" name="complete" value="1" <?= $complete ?>></td>
		</tr>
		<tr>
			<td>
				<?= $input_hidden ?>
				<input type="submit" name="envoyer" />
			</td>
			<td>
			</td>
		</tr>
	</table>
</form>
<hr />
<?php
require_once('../includes/html/include_footer.php');
?>