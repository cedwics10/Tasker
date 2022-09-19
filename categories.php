<?php 
require_once('includes/head.html');
require_once('includes/include_categories.php');
?>
<h1 style="text-align: center;">Gérez vos catégories créées.</h1></br></br>
<?php echo $message_user; ?>
<br />
<u>- Liste des catégories déjà créées :</u>
<table>
<tr><td>Id</td><td>Titre</td><td>Nb tâches</td><td>X</td></tr>
<?php
show_categories($pdo)
?>
</table>
<hr />
<?php echo $form_usage; ?> une nouvelle catégorie :
<form action="categories.php" method="post">
	<input type="text" name="category"/>
	<input type="submit">
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
	require_once('includes/footer.html');
?>