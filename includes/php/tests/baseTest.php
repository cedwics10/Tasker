<?php
require(realpath(dirname(__FILE__)) . '\..\include_base.php');
use PHPUnit\Framework\TestCase as TestCase;

class baseTest extends TestCase{
    public function testEmptyQmark() {
        
        $this->assertEquals(qmark_part(), '?', 'Test qmark_mark function with no arguments.');
    }
}
?>