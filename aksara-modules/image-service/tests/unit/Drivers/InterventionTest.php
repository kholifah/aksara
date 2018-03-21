<?php

use Plugins\ImageService\Drivers\Intervention;
use Plugins\ImageService\ImageManagerContract;
use Plugins\ImageService\FileContract;
use Intervention\Image\ImageManager;
use Mimey\MimeTypes;
use Faker\Factory as Faker;

class InterventionTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldMake()
    {
        $filename = $this->faker->md5;
        $extension = 'jpg';

        $path = "$filename.$extension";
        $mime = 'image/jpeg';

        $mimes = $this->getMockBuilder(MimeTypes::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mimes->expects($this->once())
            ->method('getMimeType')
            ->with($extension)
            ->willReturn($mime);

        $imgManager = $this->getMockBuilder(ImageManager::class)
            ->getMock();

        $mockImage = $this->getMockBuilder(MockImage::class)
            ->getMock();

        $imgManager->expects($this->once())
            ->method('make')
            ->with($path)
            ->willReturn($mockImage);

        $file = $this->getMockBuilder(FileContract::class)
            ->getMock();

        $file->expects($this->once())
            ->method('extension')
            ->with($path)
            ->willReturn($extension);

        $driver = new Intervention(
            $mimes,
            $imgManager,
            $file
        );

        $actual = $driver->make($path);

        $this->assertEquals($mockImage, $actual);
    }
}
