<?php

use Plugins\ImageService\ImageSizeConfig;
use Plugins\ImageService\ConfigRepository;
use Plugins\ImageService\ImageSize;
use Plugins\ImageService\Size;
use Faker\Factory as Faker;

class ImageSizeConfigTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldFailRegisterImageSize()
    {
        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $existingConfig = [
            $this->faker->slug => [
                'width' => $this->faker->numberBetween(1, 1000),
                'height' => $this->faker->numberBetween(1, 1000),
                'crop' => $this->faker->boolean,
                'aspect_ratio' => $this->faker->boolean,
            ],
        ];

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $imgConfig = new ImageSizeConfig($config);

        $size = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $size->expects($this->once())
            ->method('getWidth')
            ->willReturn(0);

        $size->expects($this->once())
            ->method('getHeight')
            ->willReturn(0);

        $this->expectException(Exception::class);
        $imgConfig->registerImageSize($size);
    }

    /** @test */
    public function shouldRegisterImageSize()
    {
        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $existingConfig = [
            $this->faker->slug => [
                'width' => $this->faker->numberBetween(1, 1000),
                'height' => $this->faker->numberBetween(1, 1000),
                'crop' => $this->faker->boolean,
                'aspect_ratio' => $this->faker->boolean,
            ],
        ];

        $newConfig = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
        ];

        $expectedResult = array_merge($existingConfig, $newConfig);

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $config->expects($this->once())
            ->method('set')
            ->with('aksara.image-service.image-sizes', $expectedResult);

        $imgConfig = new ImageSizeConfig($config);

        $size = $this->getMockBuilder(ImageSize::class)
            ->disableOriginalConstructor()
            ->getMock();

        $size->expects($this->any())
            ->method('getWidth')
            ->willReturn($width);

        $size->expects($this->any())
            ->method('getHeight')
            ->willReturn($height);

        $size->expects($this->once())
            ->method('toArray')
            ->willReturn($newConfig);

        $this->assertTrue($imgConfig->registerImageSize($size));
    }

    /** @test */
    public function shouldFailGetRegisteredImage()
    {
        $existingConfig = [
            $this->faker->slug => [
                'width' => $this->faker->numberBetween(1, 1000),
                'height' => $this->faker->numberBetween(1, 1000),
                'crop' => $this->faker->boolean,
                'aspect_ratio' => $this->faker->boolean,
            ],
        ];

        $notRegistered = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
        ];

        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $imgConfig = new ImageSizeConfig($config);

        $size = $this->getMockBuilder(Size::class)
            ->disableOriginalConstructor()
            ->getMock();

        $size->expects($this->any())
            ->method('getWidth')
            ->willReturn($width);

        $size->expects($this->any())
            ->method('getHeight')
            ->willReturn($height);

        $result = $imgConfig->getRegisteredImage($size);
        $this->assertFalse($result);
    }

    /** @test */
    public function shouldGetRegisteredImage()
    {
        $existingConfig = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
            $this->faker->slug => [
                'width' => $this->faker->numberBetween(1, 1000),
                'height' => $this->faker->numberBetween(1, 1000),
                'crop' => $this->faker->boolean,
                'aspect_ratio' => $this->faker->boolean,
            ],
        ];

        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $imgConfig = new ImageSizeConfig($config);

        $size = $this->getMockBuilder(Size::class)
            ->disableOriginalConstructor()
            ->getMock();

        $size->expects($this->any())
            ->method('getWidth')
            ->willReturn($width);

        $size->expects($this->any())
            ->method('getHeight')
            ->willReturn($height);

        $result = $imgConfig->getRegisteredImage($size);

        $this->assertEquals($name, $result->getName());
        $this->assertEquals($width, $result->getWidth());
        $this->assertEquals($height, $result->getHeight());
        $this->assertEquals($crop, $result->getCrop());
        $this->assertEquals($aspectRatio, $result->getAspectRatio());
    }

    /** @test */
    public function shouldHandleNotConfiguredGetImageSize()
    {
        $existingConfig = [
            $this->faker->slug => [
                'width' => $this->faker->numberBetween(1, 1000),
                'height' => $this->faker->numberBetween(1, 1000),
                'crop' => $this->faker->boolean,
                'aspect_ratio' => $this->faker->boolean,
            ],
        ];

        $notRegistered = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
        ];

        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $imgConfig = new ImageSizeConfig($config);

        $result = $imgConfig->getImageSize($name,
            '/uploads/sample.jpg');

        $expectedResult = "/uploads/sample.jpg";

        $this->assertEquals($expectedResult, $result);
    }

    /** @test */
    public function shouldGetImageSize()
    {
        $existingConfig = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
        ];

        $config = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $config->expects($this->once())
            ->method('get')
            ->with('aksara.image-service.image-sizes', [])
            ->willReturn($existingConfig);

        $imgConfig = new ImageSizeConfig($config);

        $result = $imgConfig->getImageSize($name,
            '/uploads/sample.jpg');

        $expectedResult = "/uploads/sample-$width".'x'."$height.jpg";

        $this->assertEquals($expectedResult, $result);
    }
}
