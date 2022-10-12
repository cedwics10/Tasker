<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

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
<?php 
require_once('../includes/html/include_footer.php');
?>