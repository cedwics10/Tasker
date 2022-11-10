<?php
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_index.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h3><?= SUCCESSFUL_LOGIN_MESSAGE; ?></h3>

<?php if (isset($_SESSION['id'])) { ?>
    <table>
        <caption>List ede catégories des tâches déjà créées</caption>
        <tr>
            <td>ID</td>
            <td>Nom</td>
            <td>Accès</td>
        </tr>
        <?php
        $liste_categorie = text_category_list();

        foreach ($liste_categorie->fetchAll() as $no => $fields_tache_row) { ?>
            <tr>
                <td><?= $fields_tache_row['id'] ?></td>
                <td><?= htmlentities($fields_tache_row['categorie']) ?></td>
                <td><a href="?categorie=<?= $fields_tache_row['id'] ?>">liste</a></td>
            </tr>
        <?php    } ?>
        <table>


            <table id="taches">
                <caption>
                    <h3>Liste des tâches.</h3>
                    <a class="" href="<?= make_stripped_get_args_link(['show_complete_tasks'], ['show_complete_tasks' => TasksConst::$get_arg_complete]) ?>"><?= TasksConst::$str_complete ?></a> les tâches terminées - Ordonner les tâches par :<br />
                    <?php foreach (ARRAY_ORDER_BY_TACHES as $cle => $o_by) { ?>
                        <a href='<?= make_stripped_get_args_link(['order_by'], ['order_by' => $cle]) ?>'><?= $cle ?></a>, <?php } ?>
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
                foreach (fetch_list_taches() as $row) {
                    extract($row);
                    $class_s =  ($complete === 1) ? 'class="barrer"' :  '';
                    $checked_termine =  ($complete === 1) ? 'checked' : '';
                ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td id="titre_tache<?= $id ?>" <?= $class_s ?>><?= htmlentities($nom_tache) ?></td>
                        <td><?= htmlentities($categorie) ?></td>
                        <td class="description"><?= htmlentities($description) ?></td>
                        <td class="importance"><?= generate_importance($importance) ?></td>
                        <td><?= $date ?></td>
                        <td class="termine_tache"><input type="checkbox" id="termine<?= strval($id) ?>" onclick="BarrerTexte(<?= $id ?>)"'<?= $checked_termine ?>/></td>
                    </tr>
<?php
                }
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