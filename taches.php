<?php 
require_once('includes/head.php');
require_once('includes/include_taches.php');
?>

<h1 style="text-align: center;">Créer et gérer vos tâches à faire</h1></br></br>
<?php echo $texte_nom_cat ?><br />
<form method="post" action="taches.php">
<select name="id_categorie" id="categorie_parcourir">
    <option value="">Séléctionner une autre catégorie</option>
    <?php echo $options_categories; ?>
</select>
</form>
</b></br>
<hr />

<table>
<tr>
	<td><b>Créer une nouvelle tâche</b></td><td></td>
</tr>
<form action="taches.php" method="post">
<tr>
	<td>Nom de la tâche</td>
	<td><input type="text" name="nom_tache"/></td>
</tr>
<tr>
	<td>Jour de la réalisation de la tâche</td>
	<td><input type="date" name="date"/></td>
</tr>
<tr>
	<td>Date rappel de la réalisation de la tâche (optioneel <input type="checkbox" name="date_rappel_ok"/> ):</td>
	<td><input type="date" name="date_rappel"/></td>
</tr>
<tr>
	<td>Catégorie de la tâche</td>
	<td>
		<select name="id_categorie" id="id_categorie">
				<option value="">Séléctionner une autre catégorie</option>
				<?php echo $options_categories; ?>
		</select>
	</td>
</tr>
<tr>
	<td>Description de la tâche</td>
	<td>
		<textarea id="description" name="description">
		</textarea>
	</td>
</tr>
	<tr>
		<td>
			<input type="hidden" name="nouvelle_tache" value="envoyer"/>
			<input type="submit" name="envoyer" />
		</td>
		<td>
		</td>
	</tr>
</table>
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>