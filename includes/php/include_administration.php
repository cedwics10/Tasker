<?php
$m_erreur = '';
$ne_pas_aff_page = true;

$post_avatar = '';

if(isset($_SESSION['role']) and $_SESSION['role'] == 'a')
{
    $ne_pas_aff_page = false;

}
else
{
    $m_erreur = 'Vous n\'avez pas le droit d\'accéder à cette page.';
}

?>