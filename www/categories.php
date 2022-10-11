<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_categories.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>
<h1 style="text-align: center;">Gérez vos catégories créées.</h1></br></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a></br>
<?php echo $message_user; ?>
<br />
<u>Liste des catégories déjà créées :</u>
<table>
<tr><td>ID</td><td>Titre</td><td>Nb tâches</td><td>X</td><td>E</td></tr>
<?php
show_categories($pdo)
?>
</table>
<hr />
<?php echo $form_usage; ?> une catégorie :
<form action="categories.php?<?=$editer_url?>" method="post">
	<input type="text" name="category<?=$editer?>" value="<?=htmlentities($f_category)?>"/>
	<?=$hidden?>
	<input type="submit">
</form>
<hr />
<?php 
require_once('../includes/html/include_footer.php');
?>