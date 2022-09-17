<?php 
require_once('includes/base.php');
require_once('includes/include_index.php');
require_once('includes/head.html');
?>
<h1 style="text-align:center;">To-do list : liste des tâches</h1></br>
<hr />
TÂCHEs A FAIRE :</br>
<?php
echo taches_date($pdo);
?>
</br></br>
<a href="categories.php"> Créer de nouvelles catégories</a> - <a href="taches.php"> Créer de nouvelles tâches</a>
<?php 
require_once('includes/footer.html');
?>