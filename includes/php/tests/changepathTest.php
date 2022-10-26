<?php
use PHPUnit\Framework\TestCase as TestCase;

class changepathTest extends TestCase
{
    public function testEmptyP() 
    {
        $this->assertEquals(change_base_name(''), '/', 'Empty parameters returns empty');
    }

    public function testSimplePEdit() 
    {
        $this->assertEquals(change_base_name('C:/Fichiers/Avatar/jour/lundi.jpg', 'vendredi.jpg'), 'C:/Fichiers/Avatar/jour/vendredi.jpg', 'Mere directory editing');
    }
}
?>