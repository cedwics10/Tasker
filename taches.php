<?php 
require_once('includes/base.php');
require_once('includes/include_taches.php');
require_once('includes/head.html');
?>

<h1 style="text-align: center;">Créer et gérer vos tâches à faire</h1></br></br>
<form method="get" action="taches.php">
<?php echo $texte_nom_cat ?> 
<select name="id_categorie" id="id_categorie" onChange="this.parentNode.submit()">
		<option value="">Séléctionner une autre catégorie</option>
		<?php echo $options_categories; ?>
	</select>
</form>
<?php
if(isset($desc_categories))
{
	echo($desc_categories);
}
?>
<hr />

<form action="taches.php" method="post">
	<table>
		<tr>
			<td><b><?=$action_formulaire?> une tâche</b></td><td></td>
		</tr>

		<tr>
			<td>Nom de la tâche</td>
			<td><input type="text" name="nom_tache" value="<?=$nom_tache?>"/></td>
		</tr>
		<tr>
			<td>Jour de la réalisation de la tâche</td>
			<td><input type="date" name="date" value="<?=$jour_realisation?>"/></td>
		</tr>
		<tr>
			<td>Date rappel de la réalisation de la tâche (optioneel <input type="checkbox" name="date_rappel_ok"/> ):</td>
			<td><input type="date" name="date_rappel" value="<?=$date_rappel?>"/></td>
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
				<textarea id="description" name="description" value="<?=$description_taches?>"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<?=$input_hidden?>
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
require_once('includes/footer.html');
?>