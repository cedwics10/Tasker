<?php
use PHPUnit\Framework\TestCase as TestCase;

class changepathTest extends TestCase
{
    public function testEmptyP() 
    {
        $this->assertEquals(ChangeBaseName(''), '/', 'Empty parameters returns empty');
    }

    public function testSimplePEdit() 
    {
        $this->assertEquals(ChangeBaseName('C:/Fichiers/Avatar/jour/lundi.jpg', 'vendredi.jpg'), 'C:/Fichiers/Avatar/jour/vendredi.jpg', 'Mere directory editing');
    }
}
?>