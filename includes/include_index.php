<?php
$liste_categories = '';

function liste_categories($pdo, $id = NULL)
{
	$liste_categories = '';

	$sql = 'SELECT id, categorie FROM categories';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	foreach($stmt->fetchAll() as $no => $row)
	{
		$liste_categories .= '<tr>
		<td>' . $row['id'] . '</td>
		<td>' . $row['categorie'] . '</td>
		<td><a href="?categorie=' . $row['id'] . '">liste</a></td>
		</tr>';
	}

	return $liste_categories;
}

function taches_date($pdo, $jour_en_p = 0)
{
	$sql_exec = [];
	$where = '';
	if(isset($_GET['categorie']))
	{
		if(is_numeric($_GET['categorie']))
		{
			$where = 'WHERE taches.id_categorie = ?';
			$sql_exec[] = $_GET['categorie'];
		}
	}

	$sql_q = 'SELECT taches.*, categories.categorie FROM taches LEFT JOIN categories ON
	categories.id = taches.id_categorie '  . $where . ' GROUP BY taches.id';
    
    $sth = $pdo->prepare($sql_q);
	$sth->execute($sql_exec);

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

$liste_categorie = liste_categories($pdo);
?>