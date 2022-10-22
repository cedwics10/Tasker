<?php
use PHPUnit\Framework\TestCase as TestCase;

class checkavatarTest extends TestCase
{
    public function testEmptyCheckAvatar() 
    {
        $this->assertEquals(check_avatar(), true, 'Empty FILES = no upload test.');
    }

    public function testUploadAvatar() 
    {
        $this->assertEquals(check_avatar(), true, 'Empty FILES = no upload test.');
    }
}
?>