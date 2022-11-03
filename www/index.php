<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h3><?=$message_successful_signup?></h3>

<?php if(isset($_SESSION['id']))
{ ?>
<table id="taches">
<caption>
<h3>Liste des tâches.</h3>
    <a class="" href="<?=make_stripped_get_args_link(['show_complete_tasks'], ['show_complete_tasks' => TasksConst::$get_arg_complete])?>"><?=TasksConst::$str_complete?></a> les tâches terminées  - Ordonner les tâches par :<br />
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
} else {
?>
<h3>Bienvenu sur le site des todolistes.</h3>

Vous voulez faire en sorte de planifier vos objectifs et de vous dépasser !<br />
Pour les moins motivés : vous souhaitez trouver de nouveaux objectifs pour ne jamais vous ennuyer dans votre journée (défi drôle ou des défis réels) !<br />
Inscrivez-vous, et votre rêve deviendra alors réalité.<br />
<br />
Vous gagnerez beaucoup de temps, du temps que vous consacrerez à faire vos projets et non les planiffier.<br />
Pensez à ce site dès que vous aurez un jour de week-end ennuyeux ou une organisation à construire. Notre site est 100% sécurisé et assure une pérrenité de la donnée sur le serveur. <br />
Les informations sont conservées sur un cloud extérieur et vosu assure de ne jamais perdre de vue vos objectifs.
<?php
}
?>
</table>
</br>
<?php 
require_once('../includes/html/include_footer.php');
?>