<?php
$error_message = '';
$show_page = false;

if(isset($_SESSION['role']) and $_SESSION['role'] === IS_AN_ADMIN)
{
    $show_page = true;

}
else
{
    $error_message = 'Vous n\'avez pas le droit d\'accéder à cette page.';
}

?>