<?php 
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_administration.php');

if($dont_show_page)
{
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", RESET_HEADER_ADMIN, 404);
    exit();
}

require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>

<h1>Page d'administration</h1>
<h3 id="erreur"><?=$error_message?></h3>

La page d'administration permet d'éditer l'ensemble des paramètres de tous les membres et du site, c'est-à-dire les données vous permettrant de configurer votre accès personnalisé au compte.<br />

<!--
- Modifier les infos (avatar, mdp, description, statut)
- Consulter les données d'un membre ainsi que son adresse IP
--> 
<?php
require_once('../includes/html/include_footer.php');
?>