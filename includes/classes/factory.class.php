<?php
require_once('task.class.php');

/** Class Factory
* Patorn "Factory" de la majorité des classes du projet TODO
**/ 
Class Factory
{
    /**
	* @var string Class to make
	**/
    static public function class(string $classname)
    {
        $pdo = monSQL::getPdo();
        $classname = strtolower($classname);
        switch ($classname) {
            case 'monsql':
                return $pdo;
            case 'tache':
                return new Tache($pdo);
            case 'table':
                return new Table($pdo);
            # case 'Liste':
            #    return new List($pdo);
        }
    }
}

$tache = Factory::class('tache');

$tache->selectTache(40);
print_r($tache);
?>