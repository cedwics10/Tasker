<?php 
require('../constants.php');
/** Class SqlConnect
* Permet de faire le singleton d'une connexion Sql
**/ 
class monSQL
{
    private static $host = 'localhost';
    private static $database = 'tasker';
    private static $login = 'root';
    private static $password = '';
    private static $pdo = NULL;
    
    public static function getPdo()
    {  
        if(monSQL::$pdo == NULL)
        {
            try
            {
                monSQL::$pdo = new PDO("mysql:host=" . monSQL::$host . ";dbname=" . monSQL::$database , 
                monSQL::$login, monSQL::$password);
            }
            catch (PDOException $e) 
            {
                die("Erreur !: " . $e->getMessage() . "<br/>");
            }
        }
        return monSQL::$pdo;
    }

}