<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/php/include_taches.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h3>Consulter/Editer des tâches de chaque catégorie:</h3>

<form method="get" action="">
<?php echo $texte_nom_cat ?> 
	<select name="id_categorie" id="id_categorie" onChange="this.parentNode.submit()">
		<option value="">Séléctionner une autre catégorie</option>
		<?php echo $select_options_categories; ?>
	</select>
</form>
<?=$description_categories?>
<hr />
<form action="taches.php<?=$get_link?>" method="post">
	<table>
		<tr>
			<td><b><?=$action_formulaire?></b></td><td></td>
		</tr>

		<tr>
			<td>Nom de la tâche</td>
			<td><input type="text" name="nom_tache" value="<?=htmlentities($nom_tache)?>"/></td>
		</tr>
		<tr>
			<td>Jour de la réalisation de la tâche</td>
			<td><input type="date" name="date_tache" id="date_tache" value="<?=$date_tache?>"/></td>
		</tr>
		<tr>
			<td>Date de rappel (identique à la tâche <input type="checkbox" id="ch_rappel_tache" name="ch_rappel_tache" onclick="DateRappel()"/> ) :</td>
			<td><input type="date" name="d_rappel_tache" id="d_rappel_tache" value="<?=$d_rappel_tache?>"/></td>
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
			<td><textarea id="description" name="description"><?=htmlentities($description)?></textarea></td>
		</tr>
		<tr>
			<td>Importance de la tâche</td>
			<td>
			<?=input_importance($importance)?>
			</td>
		</tr>
		<tr>
			<td>Terminé ?</td>
			<td><input type="checkbox" name="complete" value="1" <?=$complete?>></td>
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
<hr />
<?php 
require_once('../includes/html/include_footer.php');
?>