<?php 
require('../constants.php');
/** Class SqlConnect
* Permet de faire le singleton d'une connexion Sql
**/ 
class SqlConnect
{
    /**
	* @var string Serveur de connexion SQL
	**/
    private static $host = 'localhost';
    /**
	* @var string Nom de la base de données SQL choisie
	**/
    private static $dbname = 'tasker';
    /**
	* @var string Identifiant de connexion à la base SQL
	**/
    private static $login = 'root';
    /**
	* @var string Mot de passe de connexion à la base SQL
	**/
    private static $password = '';
    /**
	* @var Pdo Connexion à la base SQL.
	**/
    private static $pdo = NULL; 
    
    public static function GetPdo() # TODO : commenter la fonction
    {
        if(self::$pdo !== NULL)
        {
            return self::$pdo;
        }

        try 
        {
            $data = new SqlConnect();
            self::$pdo = new PDO(
            'mysql:host=' . self::$host . ';'
            . 'dbname=' . self::$dbname, 
            self::$login, 
            self::$password);
        }
        catch (PDOException $e) 
        {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        return self::$pdo;
    }
}