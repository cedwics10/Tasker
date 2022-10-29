<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h3><?=$message_successful_signup?></h3>

<table id="taches">
<caption>
<h3>Liste des tâches.</h3>
    <a class="" href="<?=make_stripped_get_args_link(['show_complete_tasks'], ['show_complete_tasks' => $get_arg_complete])?>"><?=TasksConst::$str_complete?></a> les tâches terminées  - Ordonner les tâches par :<br />
    <?php foreach(ARRAY_ORDER_BY_TACHES as $cle => $o_by) { ?>
    <a href='<?=make_stripped_get_args_link(['order_by'], ['order_by' => $cle])?>'><?=$cle?></a>, <?php } ?>
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
echo select_list_taches($pdo);
?>
</table>
</br>
<?php 
require_once('../includes/html/include_footer.php');
?>