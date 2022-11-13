<?php
require_once('make.class.php');

$tache = Make::class('Task');

$tache->selectTache(40);
$post = ['importance' =>  3,
        'date' => '2020-10-10'
];
$tache->update($post);
?>