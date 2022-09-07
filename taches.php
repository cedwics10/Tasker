<?php 
require_once('includes/head.php');
require_once('includes/include_taches.php');
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

<table><tr><td>Créer une nouvelle tâche :</td><td></td></tr>
<form action="taches.php" method="post">
<tr>
	<td>Nom de la tâche :</td>
	<td><input type="text" name="nom_tache"/>
</tr>
<tr>
	<td>Jour de la réalisation de la tâche :</td>
	<td><input type="date" name="date_limite"/></td>
</tr>
<tr>
	<td>Date rappel de la réalisation de la tâche (optioneel <input type="checkbox" name="date_rappel_ok"/> ):</td>
	<td><input type="date" name="date_limite"/></td>
</tr>
<tr>
	<td>Catégorie de la tâche :</td><td><select name="categorie_parcourir" id="categorie_parcourir"></td>
    <td><option value="">Séléctionner une autre catégorie</option>
    <?php echo $options_categories; ?>
	</select></td>
</tr>
	<input type="hidden" name="nouvelle_tache" value="envoyer"/>
	<tr><td><input type="submit" name="envoyer" /></td></tr>
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>