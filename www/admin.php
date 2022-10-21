<?php
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_admin.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>
<h1>Page d'options</h1>
<h3 id="erreur"><?=$m_erreur?></h3>

La page d'administration permet d'éditer l'ensemble des paramètres de tous les membres, c'est-à-dire les données vous permettrant de configurer votre accès personnalisé au compte.<br />
<?php if ($afficher_formulaire) { ?>
<form method="post" action="options.php" enctype="multipart/form-data">>
    <label for="mot_de_passe">Ancien mot de passe :</label> <input type="password" name="mot_de_passe"><br />
    <label for="n_mot_de_passe">Nouveau mot de passe :</label> <input type="password" name="n_mot_de_passe"><br />
    <label for="c_n_mot_de_passe">Confirmation :</label> <input type="password" name="c_n_mot_de_passe"><br />
    
    <label for="avatar">Nouvel avatar :</label> <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg"> <?=$value?><br />
    <input type="submit" name="btsubmit" value="Envoyer" />
</form>
<?php
}
require_once('../includes/html/include_footer.php');
?>