<?php
require 'Math.php';

// use PHPUNIT_Framework_TestCase as TestCase;
// sometimes it can be
use PHPUnit\Framework\TestCase as TestCase;

class MathTest extends TestCase{
    public function testFibonacci() {
        $math = new Math();
        $this->assertEquals(34, $math->fibonacci(9));
    }

    public function testFactorial() {
        $math = new Math();
        $this->assertEquals(720, $math->factorial(6));
    }

    public function testFactorialGreaterThanFibonacci() {
        $math = new Math();
        $this->assertTrue($math->factorial(6) > $math->fibonacci(6));
    }
}

?>