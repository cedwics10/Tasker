<?php 
try 
{
    $pdo = new PDO('mysql:host=localhost;dbname=tasker', 'root', '');
} 
catch (PDOException $e) 
{
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>

- Liste des catégories déjà créées :</br>
<?php
$stmt = $pdo->query("SELECT * FROM categories");
$result_exists = false;

while($row = $stmt->fetch())
{
    echo $row['categorie']."<br />\n";
	if(!$result_exists)
	{
		$result_exists = true;
	}
}

if(!$result_exists)
{
	echo 'Aucune catégorie n\'a été créée';
}


?>
<hr /></br>