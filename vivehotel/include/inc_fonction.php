<?php
//Protection contre l'injection SQL
function mres($s) {
    global $link;
    return mysqli_real_escape_string($link,$s);
}

//Protection contre l'injection javascript/HTML
function mhe($s) {
	return htmlentities($s,ENT_QUOTES,"utf-8");
}