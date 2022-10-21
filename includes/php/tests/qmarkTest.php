<?php
use PHPUnit\Framework\TestCase as TestCase;

class qmarkTest extends TestCase
{
    public function testEmptyQmark() 
    {
        $this->assertEquals(qmark_part([], []), '?', 'Test qmark_mark function with no arguments.');
    }

    public function testEmptyWStringQmark()
    {
        $this->assertEquals(qmark_part([], [], 'test'), '?test', 'Test qmark_mark function with no arguments except a text.');
    }

    # Create tests with a _GET function
}

?>