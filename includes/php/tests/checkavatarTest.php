<?php
use PHPUnit\Framework\TestCase as TestCase;

class checkavatarTest extends TestCase
{
    public function testEmptyCheckAvatar() 
    {
        $this->assertEquals(check_avatar(), true, 'No file = it\'s ok to get the same image');
    }

    public function testUploadTooBigAvatar() 
    {
        $image_path = 'mock_data/toobigheight.jpg';
        $_FILES = [
            'avatar' => [
                'tmp_name' => $image_path,
                'name' => $image_path,
                'type' => 'image/jpg',
                'error' => 0,
                'size' => getimagesize($image_path)
            ],
        ];
        check_avatar();
        $this->assertEquals(check_avatar(), false, 'An avatar whose height is too big is refused.');
    }

    public function testUploadMP3()
    {
        $image_path = 'mock_data/notimage.mp3';
        $_FILES = [
            'avatar' => [
                'tmp_name' => $image_path,
                'name' => $image_path,
                'type' => filetype($image_path),
                'error' => 0,
                'size' => getimagesize($image_path)
            ],
        ];
        $this->assertEquals(check_avatar(), false, 'A file which is not an image is refused');
    }

    // Perform a successful upload test
}
?>