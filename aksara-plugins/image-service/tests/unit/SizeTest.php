<?php

use Faker\Factory as Faker;
use Plugins\ImageService\Size;

class SizeTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        $size = new Size(
            $width = $this->faker->numberBetween(1, 1000),
            $height = $this->faker->numberBetween(1, 1000)
        );

        $this->assertEquals($width, $size->getWidth());
        $this->assertEquals($height, $size->getHeight());
    }

}
