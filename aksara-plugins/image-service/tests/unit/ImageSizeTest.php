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
    }
}
