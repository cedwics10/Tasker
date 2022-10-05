<?php 
require_once('includes/base.php');
require_once('includes/include_index.php');
require_once('includes/head.html');
?>
<h1 style="text-align:center;">To-do list : liste des tâches</h1></br>
<hr />
Liste des catégories :
<table>
<tr>
    <td>ID</td>
    <td>Nom</td>
    <td>tâches</td>
</tr>
<?=$liste_categorie?>
<tr>
    <td></td>
    <td>=></td>
    <td><a href="index.php">INDEX</a></td>
</tr>
</table>
<hr />
<h3>Liste des tâches.</h3>
<a href="<?=qmark_part(['aff_complete'], ['aff_complete' => $get_complete])?>"><?=$str_complete?></a> les tâches terlubées - Ordonner les tâches par :
<?php foreach(ORDER_ARRAY as $cle => $o_by) { ?>
<a href='<?=qmark_part(['order_by'], ['order_by' => $cle])?>'><?=$cle?></a>, 
<?php } ?>
<table>
<tr>
    <td>ID</td>
    <td class="titre_tache">Nom tâche</td>
	<td>Catégorie</td>
    <td>Description</td>
    <td>Importance</td>
    <td>Date</td>
	<td>Terimné ?</td>
</tr>
<?php
echo taches_date($pdo);
?>
</table>
</br>
</br>
<a href="categories.php"> Créer de nouvelles catégories</a> - <a href="taches.php"> Créer de nouvelles tâches</a>
<?php 
require_once('includes/footer.html');
?>