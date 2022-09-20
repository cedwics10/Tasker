<?php
function taches_date($pdo, $jour_en_p = 0)
{
	$sql_q = 'SELECT taches.*, categories.categorie FROM taches LEFT JOIN categories ON
	categories.id = taches.id_categorie GROUP BY taches.id';
    
    $sth = $pdo->prepare($sql_q);
	$sth->execute(); // [$id_cat]

	$categories = $sth->fetchAll();

    $desc_taches = '';
	foreach ($categories as $row) {
		$desc_taches .= '<tr>' . PHP_EOL . '
		<td>' . $row['id'].'</td>' . PHP_EOL . '
		<td class="titre_tache">' . $row['nom_tache'].'</td>' . PHP_EOL . '
		<td>' . $row['categorie'] . '</td>' . PHP_EOL . '
		<td>' . $row['description'].'</td>' . PHP_EOL . '
		<td>' . $row['date'] . '</td>' . PHP_EOL . '
		</tr>' . PHP_EOL ;
	}
    return $desc_taches;
}
?>