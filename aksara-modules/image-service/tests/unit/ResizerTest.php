<?php

use Plugins\ImageService\Resizer;
use Plugins\ImageService\ImageManagerContract;
use Plugins\ImageService\ImageSizeConfig;
use Plugins\ImageService\ImageSize;
use Plugins\ImageService\Size;
use Faker\Factory as Faker;
//use Plugins\ImageService\ImagePath;

class ResizerTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldHandleInvalidFormat()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $fakeOriginalPath = '/tmp/' . $this->faker->uuid . '.jpg';
        $fileNameInfo = explode('.', $fakeOriginalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = $fakeOriginalPath;

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertFalse($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldHandleFileNotFound()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $fakeOriginalPath = '/tmp/' . $this->faker->uuid . '.jpg';
        $fileNameInfo = explode('.', $fakeOriginalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertFalse($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldHandleNoConfig()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $imgConfig->expects($this->once())
            ->method('getRegisteredImage')
            ->with($size)
            ->willReturn(false);

        //NOTE: harus connect internet untuk tes ini
        $originalPath = $this->faker->image;
        $fileNameInfo = explode('.', $originalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertFalse($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldResizeWithCrop()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $config = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $config->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $imgConfig->expects($this->once())
            ->method('getRegisteredImage')
            ->with($size)
            ->willReturn($config);

        //NOTE: harus connect internet untuk tes ini
        $originalPath = $this->faker->image;
        $fileNameInfo = explode('.', $originalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $mockImage = $this->getMockBuilder(MockImage::class)
            ->getMock();

        $mockImage->expects($this->once())
            ->method('crop')
            ->with($width, $height);

        $imgManager->expects($this->once())
            ->method('make')
            ->with($originalPath)
            ->willReturn($mockImage);//TODO

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertTrue($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldResizeWithFit()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $config = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->expects($this->once())
            ->method('getCrop')
            ->willReturn(true);

        $config->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $config->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $imgConfig->expects($this->once())
            ->method('getRegisteredImage')
            ->with($size)
            ->willReturn($config);

        //NOTE: harus connect internet untuk tes ini
        $originalPath = $this->faker->image;
        $fileNameInfo = explode('.', $originalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $mockImage = $this->getMockBuilder(MockImage::class)
            ->getMock();

        $mockImage->expects($this->once())
            ->method('fit')
            ->with($width, $height);

        $imgManager->expects($this->once())
            ->method('make')
            ->with($originalPath)
            ->willReturn($mockImage);//TODO

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertTrue($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldHandleFailedMake()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $config = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $imgConfig->expects($this->once())
            ->method('getRegisteredImage')
            ->with($size)
            ->willReturn($config);

        //NOTE: harus connect internet untuk tes ini
        $originalPath = $this->faker->image;
        $fileNameInfo = explode('.', $originalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $imgManager->expects($this->once())
            ->method('make')
            ->with($originalPath)
            ->willReturn(false);

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertFalse($resizer->resize($requestPath));
    }

    /** @test */
    public function shouldResizeWithAspectRatio()
    {
        $imgManager = $this->getMockBuilder(ImageManagerContract::class)
            ->getMock();

        $imgConfig = $this->getMockBuilder(ImageSizeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);

        $size = new Size($width, $height);

        $config = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $config->expects($this->once())
            ->method('getAspectRatio')
            ->willReturn(true);

        $config->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $config->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $imgConfig->expects($this->once())
            ->method('getRegisteredImage')
            ->with($size)
            ->willReturn($config);

        //NOTE: harus connect internet untuk tes ini
        $originalPath = $this->faker->image;
        $fileNameInfo = explode('.', $originalPath);
        $filename = $fileNameInfo[0];
        $extension = $fileNameInfo[1];

        $requestPath = "$filename-$width".'x'."$height.$extension";

        $mockImage = $this->getMockBuilder(MockImage::class)
            ->getMock();

        $mockImage->expects($this->once())
            ->method('resize')
            ->with($width, $height);

        $imgManager->expects($this->once())
            ->method('make')
            ->with($originalPath)
            ->willReturn($mockImage);

        $resizer = new Resizer($imgManager, $imgConfig);

        $this->assertTrue($resizer->resize($requestPath));
    }
}

interface MockImage
{
    public function resize($width, $height, Closure $closure);
    public function fit($width, $height, Closure $closure);
    public function crop($width, $height, Closure $closure);
    public function save($path);
}
