<?php
require('pdo.class.php');

/** Class Tache
* Permet de créer, modifier et uploader une tâche rapidement
**/ 
class Tache # SINGLETON PDO
{
	/**
	* @var Pdo Database connexion
	**/
	private $pdo;
	/**
	* @var int Identifiant de la tâche choisie
	**/
	private $id;
	/**
	* @var int Identifiant de la tâche choisie
	**/
	private $id_categorie;
	/**
	* @var int Donne le nom d'une tâche
	**/
	private $nom_tache;
	/**
	* @var int Donne la date de la tâche
	**/
	private $date_tache;
	/**
	* @var int Donne la date de la rappel de la tâche
	**/
	private $d_rappel_tache;
	/**
	* @var string Decrit la tâche
	**/
	private $description;
	/**
	* @var string Indique l'importance d'une tâche
	**/
	private $importance =  MIN_IMPORTANCE_TASKS;

	public $results; # check !

	public function __construct($id = NULL)
	{
		$this->pdo = SqlConnect::GetPdo();
		$this->id = $id;
		$this->retrieve_data();
	}

	public function retrieve_data()
	{
		if($this->id === NULL)
		{
			return false;
		}
		$statement = $this->pdo->query('SELECT * FROM taches WHERE id = ' . $this->id);
		$this->results = $statement->fetchAll();
	}
}

$tache_a_editer = new Tache(23);
print_r($tache_a_editer->results);

?>