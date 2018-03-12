<?php

use Faker\Factory as Faker;
use Aksara\ModuleStatusInfo;

class ModuleStatusInfoTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        $info = new ModuleStatusInfo(
            $type = $this->faker->word,
            $moduleName = $this->faker->slug,
            $isActive = $this->faker->boolean,
            $isRegistered = $this->faker->boolean,
            $version = $this->faker->numberBetween(1, 2)
        );

        $this->assertEquals($version, $info->getVersion());
        $this->assertEquals($type, $info->getType());
        $this->assertEquals($moduleName, $info->getModuleName());
        $this->assertEquals($isActive, $info->getIsActive());
        $this->assertEquals($isRegistered, $info->getIsRegistered());

        $array = $info->toArray();

        $this->assertEquals($version, $array['version']);
        $this->assertEquals($type, $array['type']);
        $this->assertEquals($moduleName, $array['module_name']);
        $this->assertEquals($isActive, $array['is_active']);
        $this->assertEquals($isRegistered, $array['is_registered']);


    }
}
