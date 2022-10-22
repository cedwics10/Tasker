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

    public function testEmptyWMockQmark()
    {
        $this->assertEquals(qmark_part([], [], 'test'), '?test', 'Test qmark_mark function with no arguments except a text.');
    }

    public function testOneMockGetQmark()
    {
        $this->assertEquals(qmark_part([], ['test' => 'ok'], ''), '?test=ok', 'Test qmark_mark function with one get mock argument.');
    }

    public function testTwoMockMinusOneGetQmark()
    {
        $_GET['its'] = 'notok';
        $this->assertEquals(qmark_part(['its'], ['test' => 'ok'], ''), '?test=ok', 'Test qmark_mark function with no arguments except a text.');
    }

    public function testOneMockTwoGetQmark()
    {
        $_GET['its'] = 'notok';
        $_GET['test'] = 'ok';
        $this->assertEquals(qmark_part(['its'], ['but' => 'ilikeit'], ''), '?but=ilikeit&amp;test=ok', 'Test qmark_mark function with no arguments except a text.');
    }

    public function testTwoMockTwoGetAnchortQmark()
    {
        $_GET['its'] = 'notok';
        $_GET['his'] = 'test';
        $_GET['test'] = 'ok';
        $_GET['to'] = 'you';

        $this->assertEquals(qmark_part(['its', 'to'], ['but' => 'ilikeit'], '#index'), '?but=ilikeit&amp;his=test&amp;test=ok#index', 'Test qmark_mark function with no arguments except a text.');
    }
    # Create tests with injecting $_GET into the assertEqual
}

?>