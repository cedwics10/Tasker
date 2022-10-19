<?php
use PHPUnit\Framework\TestCase as TestCase;

class baseTest extends TestCase{
    public function testEmptyQmark() 
    {
        $this->assertEquals(qmark_part([], []), '?', 'Test qmark_mark function with no arguments.');
    }

    public function testEmptyWStringQmark()
    {
        $this->assertEquals(qmark_part([], [], 'test'), '?test', 'Test qmark_mark function with no arguments except a text.');
    }


    public function testEmptyGetQmark() {
        $this->assertEquals(qmark_part(['prenom'], ['prenom' => 'jean']), '?prenom=jean', 'Test qmark_mark function with one argument.');
    }
}
?>