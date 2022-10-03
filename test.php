<?php
setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');
echo utf8_encode(date('l jS \of F Y h:i:s A'));
?>