<?php

use Plugins\ImageService\ImageSize;
use Plugins\ImageService\Facades\ImageConfig;
use Faker\Factory as Faker;
use Hamcrest\Matchers;

class HelperTest extends Orchestra\Testbench\TestCase
{
    private $faker;

    protected function setup()
    {
        parent::setup();
        $this->faker = Faker::create();
    }

    protected function getPackageAliases($app)
    {
        return [
            'ImageConfig' => 'Plugins\ImageService\Facades\ImageConfig',
            'ImageService' => 'Plugins\ImageService\Facades\ImageService',
        ];
    }

    protected function getPackageProviders($app)
    {
        return ['Plugins\ImageService\Providers\ImageServiceProvider'];
    }

    /** @test */
    public function shouldRegisterImageSize()
    {
        $size = new ImageSize(
            $name = $this->faker->slug,
            $width = $this->faker->numberBetween(1, 1000),
            $height = $this->faker->numberBetween(1, 1000),
            $crop = $this->faker->boolean,
            $aspectRatio = $this->faker->boolean
        );

        ImageConfig::shouldReceive('registerImageSize')
            ->once()
            ->with(Matchers::equalTo($size))
            ->andReturn(true);

        $this->assertTrue(register_image_size(
            $name,
            $width,
            $height,
            $crop,
            $aspectRatio
        ));
    }

    /** @test */
    public function shouldGetImageSize()
    {
        $id = $this->faker->slug;
        $imageUrl = $this->faker->imageUrl;
        $sizedUrl = $this->faker->imageUrl;

        ImageConfig::shouldReceive('getImageSize')
            ->once()
            ->with($id, $imageUrl)
            ->andReturn($sizedUrl);

        $this->assertEquals($sizedUrl, get_image_size($id, $imageUrl));
    }

    /** @test */
    public function shouldGetResizedImage()
    {
        $imageUrl = $this->faker->imageUrl;
        $sizedUrl = $this->faker->imageUrl;

        ImageService::shouldReceive('resize')
            ->once()
            ->with($imageUrl)
            ->andReturn($sizedUrl);

        $this->assertEquals($sizedUrl, get_resized_image($imageUrl));
    }
}
