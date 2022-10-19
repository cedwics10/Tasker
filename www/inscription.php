<?php
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_inscription.php');
require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>
<h1>Inscription</h1>
<h3 id="erreur"><?=$m_erreur?></h3>
<form method="post" action="inscription.php#erreur">
    <label for="pseudo">Pseudo :</label> <input type="text" name="pseudo" value="<?=$pseudo;?>"><br />
    <label for="mot_de_passe">Mot de passe :</label> <input type="password" name="mot_de_passe"><br />
    <label for="c_mot_de_passe">Confirmer le mot de passe :</label> <input type="password" name="c_mot_de_passe"><br />
    <input type="submit" name="btsubmit" value="Envoyer" />
</form>
<?php 
require_once('../includes/html/include_footer.php');
?>