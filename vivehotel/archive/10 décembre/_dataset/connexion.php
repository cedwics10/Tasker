<?php
$link = mysqli_connect("localhost", "root", "", "vivehotel");
mysqli_set_charset($link,"utf8");

$dbh = new PDO('mysql:host=localhost;dbname=vivehotel', 'root', '');

$queries = file_get_contents('../vivehotel.sql');
// use the connection here
$sth = $dbh->query($queries);
?>