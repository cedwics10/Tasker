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
	* @var int Id of the task
	**/
	private $id;
	/**
	* @var int Id of the member
	**/
	private $id_membre;
	/**
	* @var int Id of the category
	**/
	private $id_categorie;
	/**
	* @var int Name of a task
	**/
	private $nom_tache;
	/**
	* @var string Decrit la tâche
	**/
	private $description;
	/**
	* @var int Due date of a task
	**/
	private $date;
	/**
	* @var int Remind date of task
	**/
	private $rappel;
	/**
	* @var string Importance of this task
	**/
	private $importance =  MIN_IMPORTANCE_TASKS;
	/**
	* @var int Status of task
	**/
	private $complete;
	/**
	* @param Pdo Data object, this class is made on the scope of the Factory class
	* @ return : nothing , dependency injection
	**/
	public function __construct(Pdo $sql)
	{
		$this->pdo = $sql;
	}

	/**
	* @param int Task id
	* @ return
	**/
	public function selectTache($id)
	{
		$statement = $this->pdo->prepare('SELECT * FROM taches WHERE id = ?');
		$statement->execute([$id]);
		
		$data = $statement->fetch(PDO::FETCH_ASSOC);

		foreach($data as $key => $value)
			$this->$key = $value;
	}

	public function getVar($name)
	{
		return $this->$name;
	}

	public function update($post)
	{
		
	}

}
?>