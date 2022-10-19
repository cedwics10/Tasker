<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h3><?=$reussi_inscription?></h3>

<table id="taches">
<caption>
<h3>Liste des tâches.</h3>
<a class="" href="<?=qmark_part(['aff_complete'], ['aff_complete' => $get_complete])?>#taches"><?=$str_complete?></a> les tâches terminées  - Ordonner les tâches par :<br />
<?php foreach(ORDER_ARRAY as $cle => $o_by) { ?>
<a href='<?=qmark_part(['order_by'], ['order_by' => $cle])?>'><?=$cle?></a>, <?php } ?>
</caption>
<tr>
    <td>ID</td>
    <td class="titre_tache">Nom</td>
	<td>Catégorie</td>
    <td class="description">Description</td>
    <td>!</td>
    <td>Date</td>
	<td>Fini ?</td>
</tr>
<?php
echo taches_date($pdo);
?>
</table>
</br>
<?php 
require_once('../includes/html/include_footer.php');
?>