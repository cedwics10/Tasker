<?php
$liste_categories = '';
$a_completes = false;
$where_complete = '';

function cookie_aff_c($cle)
{
	setcookie('aff_complete', $cle, time()+365*24*3600);
	$_COOKIE['aff_complete'] = $cle;
}

if(isset($_GET['aff_complete']))
{ 
	if($_GET['aff_complete'] == 0)
	{
		cookie_aff_c(0);
	}
	else
	{
		
		$a_completes = true;
		cookie_aff_c(1);
	}
}
elseif(isset($_COOKIE['aff_complete']) and $_COOKIE['aff_complete'] == 0)
{
	cookie_aff_c(0);
}
else
{
	$a_completes = true;
}

if($a_completes)
{
	$get_complete = 0;
	$str_complete = 'Masquer';
	$sql_complete = '';
	cookie_aff_c(1);
}
else
{
	$where_complete = 'complete != 1';
	$get_complete = 1;
	$str_complete = 'Afficher';
	cookie_aff_c(0);
}



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

function taches_date($pdo)
{
	global $where_complete;

	$sql_exec = [];
	$where = '';
	
	$key_order = 'nom';
	$order_array = [
	'date' => 'taches.date', 
	'nom' =>'taches.nom_tache',
	'categorie' => 'categories.categorie'
	// 'importance' =>'tches.importance',
	];

	if(isset($_GET['order_by']))
	{
		if(array_key_exists($_GET['order_by'], $order_array))
		{
			$key_order = $_GET['order_by'];
		}
	}

	if(isset($_GET['categorie']))
	{
		if(is_numeric($_GET['categorie']))
		{
			$where = 'WHERE taches.id_categorie = ?';
			if($where_complete != '')
			{
				$where .= ' AND ' . $where_complete;
			}
			$sql_exec[] = $_GET['categorie'];
		}
	}
	elseif($where_complete != '')
	{
		$where = 'WHERE ' . $where_complete;
	}

	$order_by = $order_array[$key_order];

	$sql_q = 'SELECT taches.*, DATE_FORMAT(taches.date,"%d/%m/%Y %H:%i:%s") AS `french_date`,' 
	. ' categories.categorie FROM taches'
	. ' LEFT JOIN categories' 
	. ' ON categories.id = taches.id_categorie'
	. ' ' . $where 
	. ' GROUP BY taches.id'
	. ' ORDER BY ' . $order_by ;

    $sth = $pdo->prepare($sql_q);
	$sth->execute($sql_exec);

	$taches = $sth->fetchAll();

    $desc_taches = '';
	foreach ($taches as $row) {
		$s = '';
		$s_end = '';
		if($row['complete'] == 1)
		{
			$s = '<s>';
			$s_end = '</s>';
		}


		$desc_taches .= '<tr>' . PHP_EOL 
		. '<td>' . $row['id'].'</td>' . PHP_EOL 
		. '<td class="titre_tache">' . $s . $row['nom_tache']. $s_end . '</td>' 
		. PHP_EOL . '<td>' . $row['categorie'] . '</td>' . PHP_EOL 
		. '<td>' . $row['description'].'</td>' . PHP_EOL
		. '<td class="importance">';

		for($i=1;$i<=3;$i++)
		{
			$ck = '';
			if(($i == 1 and !in_array($row['importance'], range(1,3))) or $i == $row['importance'])
			{
				$desc_taches .= '<img src="img/im' . str_repeat("p", $i) . '.png" alt="' . str_repeat('très', $i-1) . ' important"/>';
		
			}
		}

		$desc_taches .= '</td>' . PHP_EOL 
		. '<td>' . $row['french_date'] . '</td>' . PHP_EOL 
		. '</tr>' . PHP_EOL ;
	}
    return $desc_taches;
}

$liste_categorie = liste_categories($pdo);



?>