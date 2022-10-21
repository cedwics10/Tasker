<?php
use PHPUnit\Framework\TestCase as TestCase;

class baseTest extends TestCase
{
    public function testEmptyQmark() 
    {
        $this->assertEquals(qmark_part([], []), '?', 'Test qmark_mark function with no arguments.');
    }

    public function testEmptyWStringQmark()
    {
        $this->assertEquals(qmark_part([], [], 'test'), '?test', 'Test qmark_mark function with no arguments except a text.');
    }

    public function testModifyGetArgsNullQmark() {
        $this->assertEquals(qmark_part(['prenom'], ['prenom' => 'jack'], 'prenom=jean'), '?prenom=jean', 'Test qmark_mark function with one argument.');
    }

    public function testEmptyGetQmark() {
        $this->assertEquals(qmark_part(['prenom'], ['prenom' => 'jack'], 'prenom=jean'), '?prenom=jean', 'Test qmark_mark function with one argument.');
    }

    
    public function testDeleteArgumentsQmark() {
        $this->assertEquals(qmark_part(['prenom', 'nom'], ['prenom' => 'jack', 'nom' => 'daniels'], ''), '?', 'Test qmark_mark function by passing two get arguments but removed by second argument.');
    }

    public function testTurnToOneArgQmark() {
        $this->assertEquals(qmark_part(['nom', 'adresse'], ['prenom' => 'jack', 'nom' => 'daniels', 'adresse'=> '123ruedelabiere'], ''), '?prenom=jack', 'Test qmark_mark function and delete all arguments except one.');
    }

    public function testTurnToThreeArgsQmark() {
        $this->assertEquals(qmark_part(['nom', 'adresse', 'telephone'], ['prenom' => 'jack', 'nom' => 'daniels', 'adresse'=> '123ruedelabiere', 'telephone' => '010101', 'son' => 'grimbergen', 'likes' => 'vinblanc'], ''), '?prenom=jack&amp;son=grimbergen&amp;likes=vinblanc', 'Test qmark_mark function and delete all arguments except one.');
    }

    public function testTurnToFiveArgsAnchorQmark() {
        $this->assertEquals(qmark_part(['nom', 'adresse', 'telephone', 'chien'], ['chien' => 'toi', 'prenom' => 'jack', 'nom' => 'daniels', 'adresse'=> '123ruedelabiere', 'telephone' => '010101', 'son' => 'grimbergen', 'likes' => 'vinblanc'], ''), '?prenom=jack&amp;son=grimbergen&amp;likes=vinblanc', 'Test qmark_mark function and delete all arguments except one.');
    }
}
?>