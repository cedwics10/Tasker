<?php 
require_once('includes/head.php');
?>
Créer et gérer vos tâches à faire</br></br>
- Liste des tâches déjà créées <b>pour la catégorie {NOM}
<form method="post" action="taches.php"><select name="categorie_parcourir" id="categorie_parcourir">
    <option value="">Séléctionner une autre catégorie</option>
    <option value="dog">Dog</option>
    <option value="cat">Cat</option>
    <option value="hamster">Hamster</option>
    <option value="parrot">Parrot</option>
    <option value="spider">Spider</option>
    <option value="goldfish">Goldfish</option>
</select>
</form>
</b></br>
<hr />
Créer une nouvelle tâche :<br />
<form action="tache.php" method="post">
Nom de la tâche : <input type="text" name="nom_tache"/></br>
Jour de la réalisation de la tâche : <input type="text" name="date_limite"/></br>
Date rappel de la réalisation de la tâche (optioneel) : <input type="text" name="date_rappel"/></br>
Catégorie de la tâche : <input type="text" name="date_rappel"/></br>
	<input type="submit">
</form>
<hr /></br>
Revenir à l'accueil : <a href="index.php" label="Retour à l'accueil">cliquez-ici</a>
<?php 
require_once('includes/footer.php');
?>