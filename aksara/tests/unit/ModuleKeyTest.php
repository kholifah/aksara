<?php

use Aksara\ModuleKey;
use Faker\Factory as Faker;

class ModuleKeyTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        $key = new ModuleKey(
            $type = $this->faker->word,
            $moduleName = $this->faker->slug
        );

        $this->assertEquals($type, $key->getType());
        $this->assertEquals($moduleName, $key->getModuleName());

        $array = $key->toArray();

        $this->assertEquals($type, $array['type']);
        $this->assertEquals($moduleName, $array['module_name']);

        $this->assertEquals("$type/$moduleName", (string)$key);
    }
}
