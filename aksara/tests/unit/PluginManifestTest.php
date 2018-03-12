<?php

use Faker\Factory as Faker;
use Aksara\PluginManifest;

class PluginManifestTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        //test generate from config
        $manifest = PluginManifest::fromPluginConfig([
            'name' => $name = $this->faker->slug,
            'description' => $description = $this->faker->sentence,
            'dependencies' => $dependencies = [ $this->faker->slug ],
            'providers' => $providers = [ $this->faker->slug ],
            'aliases' => $aliases = [ $this->faker->slug ],
        ],
            $active = $this->faker->boolean
        );

        //assert getters
        $this->assertEquals($name, $manifest->getName());
        $this->assertEquals($description, $manifest->getDescription());
        $this->assertEquals($dependencies, $manifest->getDependencies());
        $this->assertEquals($providers, $manifest->getProviders());
        $this->assertEquals($aliases, $manifest->getAliases());
        $this->assertEquals($active, $manifest->getActive());

        //test conversion to array
        $array = $manifest->toManifestArray();

        $this->assertEquals($array[$name]['description'], $manifest->getDescription());
        $this->assertEquals($array[$name]['dependencies'], $manifest->getDependencies());
        $this->assertEquals($array[$name]['providers'], $manifest->getProviders());
        $this->assertEquals($array[$name]['aliases'], $manifest->getAliases());

        //test setter
        $manifest->setActive($active = $this->faker->boolean);
        $this->assertEquals($active, $manifest->getActive());
    }
}
