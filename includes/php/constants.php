<?php

const MIN_L_MDP = 8;
const MAX_L_MDP = 20;
const MIN_L_PSEUDO = 3;
const MAX_L_PSEUDO = 20;

const MAX_HEIGHT_IMAGES = 600;
const MAX_LENGTH_IMAGES = 600;
const AVATAR_EXT_OK = ["jpg", "jpeg", "png", "bmp", "gif"];

const MAX_IMPORTANCE_TASKS = 3;
const MIN_IMPORTANCE_TASKS = 1;



const ARRAY_ORDER_BY_TACHES = [
	'date' => 'taches.date', 
	'nom' =>'taches.nom_tache',
	'categorie' => 'categories.categorie',
	'importance' =>'taches.importance'
];
const TASK_IS_COMPLETED = 1;
const TASK_NOT_COMPLETED = 0;

const SHOW_COMPLETED_TASKS = 1;
const HIDE_COMPLETED_TASKS = 0;


# RASSEMBLER LES CONSTANTES

const REPLACE_HEADER_ADMIN = true;
const IS_AN_ADMIN = 'a';
?>