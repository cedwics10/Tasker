<?php
$error_message = '';
$dont_show_page = true;
$post_avatar = '';

if(isset($_SESSION['role']) and $_SESSION['role'] == IS_AN_ADMIN)
{
    $dont_show_page = false;

}
else
{
    $error_message = 'Vous n\'avez pas le droit d\'accéder à cette page.';
}

?>