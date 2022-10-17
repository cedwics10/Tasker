<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/php/include_categories.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<table class="bloc_infos">
	<caption><u>Liste des catégories déjà créées :</u></caption>
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