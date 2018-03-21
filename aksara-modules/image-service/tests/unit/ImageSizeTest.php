<?php

use Faker\Factory as Faker;
use Plugins\ImageService\ImageSize;

class ImageSizeTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        $imgSize = new ImageSize(
            $name = $this->faker->slug,
            $width = $this->faker->numberBetween(1, 1000),
            $height = $this->faker->numberBetween(1, 1000),
            $crop = $this->faker->boolean,
            $aspectRatio = $this->faker->boolean
        );

        $this->assertEquals($name, $imgSize->getName());
        $this->assertEquals($width, $imgSize->getWidth());
        $this->assertEquals($height, $imgSize->getHeight());
        $this->assertEquals($crop, $imgSize->getCrop());
        $this->assertEquals($aspectRatio, $imgSize->getAspectRatio());

        $array = $imgSize->toArray();

        $this->assertEquals($width, $array[$name]['width']);
        $this->assertEquals($height, $array[$name]['height']);
        $this->assertEquals($crop, $array[$name]['crop']);
        $this->assertEquals($aspectRatio, $array[$name]['aspect_ratio']);
    }

    /** @test */
    public function shouldCreateFromArray()
    {
        $array = [
            $name = $this->faker->slug => [
                'width' => $width = $this->faker->numberBetween(1, 1000),
                'height' => $height = $this->faker->numberBetween(1, 1000),
                'crop' => $crop = $this->faker->boolean,
                'aspect_ratio' => $aspectRatio = $this->faker->boolean,
            ],
        ];

        $imgSize = ImageSize::fromArray($name, $array[$name]);

        $this->assertEquals($name, $imgSize->getName());
        $this->assertEquals($width, $imgSize->getWidth());
        $this->assertEquals($height, $imgSize->getHeight());
        $this->assertEquals($crop, $imgSize->getCrop());
        $this->assertEquals($aspectRatio, $imgSize->getAspectRatio());
    }

    /** @test */
    public function shouldHandleWidthAspectRatio()
    {
        $imgSize = new ImageSize(
            $name = $this->faker->slug,
            $width = 0,
            $height = $this->faker->numberBetween(1, 1000),
            $crop = $this->faker->boolean,
            $aspectRatio = true
        );

        $this->assertEquals(null, $imgSize->getWidth());

        $imgSize = new ImageSize(
            $name = $this->faker->slug,
            $width = 0,
            $height = $this->faker->numberBetween(1, 1000),
            $crop = $this->faker->boolean,
            $aspectRatio = false
        );

        $this->assertEquals(9000, $imgSize->getWidth());
    }

    /** @test */
    public function shouldHandleHeightAspectRatio()
    {
        $imgSize = new ImageSize(
            $name = $this->faker->slug,
            $width = $this->faker->numberBetween(1, 1000),
            $height = 0,
            $crop = $this->faker->boolean,
            $aspectRatio = true
        );

        $this->assertEquals(null, $imgSize->getHeight());

        $imgSize = new ImageSize(
            $name = $this->faker->slug,
            $width = $this->faker->numberBetween(1, 1000),
            $height = 0,
            $crop = $this->faker->boolean,
            $aspectRatio = false
        );

        $this->assertEquals(9000, $imgSize->getHeight());
    }
}
