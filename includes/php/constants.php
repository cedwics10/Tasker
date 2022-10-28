<?php
const NUMBER_OF_SECONDS_IN_A_YEAR = 365*24*3600;
const AVATAR_OK = true;
const AVATAR_NOT_OK = false;

const MIN_L_MDP = 8;
const MAX_L_MDP = 20;
const MIN_L_PSEUDO = 3;
const MAX_L_PSEUDO = 20;

const MAX_HEIGHT_IMAGES = 600;
const MAX_LENGTH_IMAGES = 600;
const AVATAR_EXTENSION_OK = ["jpg", "jpeg", "png", "bmp", "gif"];

const MAX_IMPORTANCE_TASKS = 3;
const MIN_IMPORTANCE_TASKS = 1;

const SUCCESSFUL_SIGNUP = 'inscription_reussie';
const SUCCESSFUL_SIGNIN = 'connexion_reussie';

const ARRAY_ORDER_BY_TACHES = [
	'date' => 'taches.date', 
	'nom' =>'taches.nom_tache',
	'categorie' => 'categories.categorie',
	'importance' =>'taches.importance'
];
const TASK_IS_COMPLETED = 1;
const TASK_NOT_COMPLETED = 0;
const REGEX_VALID_TASKDATE = '"#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#"';

const SHOW_COMPLETED_TASKS = 1;
const HIDE_COMPLETED_TASKS = 0;

const MIN_LENGTH_CATEGORY_NAME = 3;
const MAX_LENGTH_CATEGORY_NAME = 100;

const RESET_HEADER_ADMIN = true;
const IS_AN_ADMIN = 'a';
const IS_A_MEMBER = 'm';
?>