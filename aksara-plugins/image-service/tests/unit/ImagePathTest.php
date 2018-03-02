<?php

use Plugins\ImageService\ImagePath;
use Faker\Factory as Faker;

class ImagePathTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldHandleFalseFormat()
    {
        $filename = $this->faker->uuid;
        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);
        $extension = "jpg";

        $urlPath = "/public/uploads/$filename.$extension";

        $imgPath = ImagePath::fromUrlPath($urlPath);
        $this->assertFalse($imgPath);
    }

    /** @test */
    public function shouldHandleTrailingFormat()
    {
        $filename = $this->faker->uuid;
        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);
        $extension = "jpg";

        $urlPath = "/public/uploads/$filename-$width".'x'.$height.'x.'.$extension;

        $imgPath = ImagePath::fromUrlPath($urlPath);
        $this->assertFalse($imgPath);
    }

    /** @test */
    public function shouldCreateFromUrlPath()
    {
        $filename = $this->faker->uuid;
        $width = $this->faker->numberBetween(1, 1000);
        $height = $this->faker->numberBetween(1, 1000);
        $extension = "jpg";

        $urlPath = "/public/uploads/$filename-$width".'x'."$height.$extension";
        $expectedOriginal = "/public/uploads/$filename.$extension";
        $imgPath = ImagePath::fromUrlPath($urlPath);

        if (!$imgPath) {
            $this->fail('Path not generated');
        }

        $this->assertEquals($width, $imgPath->getSize()->getWidth());
        $this->assertEquals($urlPath, $imgPath->getPublicPath());
        $this->assertEquals($expectedOriginal, $imgPath->getOriginalPath());
    }
}
