<?php
function taches_date($pdo, $jour_en_p = 0)
{
	$sql_q = 'SELECT nom_tache, `date` FROM taches';
    
    $sth = $pdo->prepare($sql_q);
	$sth->execute(); // [$id_cat]

	$categories = $sth->fetchAll();

    $desc_taches = '';
	foreach ($categories as $row) {
		$desc_taches .= '* Faire la tâche "' . $row['nom_tache'].'" pour le ' . $row['date'] . '<br />';
	}
    return $desc_taches;
}
?>