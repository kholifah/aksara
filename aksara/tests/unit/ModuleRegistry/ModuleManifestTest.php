<?php

use Faker\Factory as Faker;
use Aksara\ModuleRegistry\ModuleManifest;

class ModuleManifestTest extends PHPUnit\Framework\TestCase
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
        $manifest = ModuleManifest::fromModuleConfig([
            'name' => $name = $this->faker->slug,
            'description' => $description = $this->faker->sentence,
            'dependencies' => $dependencies = [ $this->faker->slug ],
            'providers' => $providers = [ $this->faker->slug ],
            'aliases' => $aliases = [ $this->faker->slug ],
        ],
            $pluginRoot = $this->faker->word
        );

        //assert getters
        $this->assertEquals($name, $manifest->getName());
        $this->assertEquals($description, $manifest->getDescription());
        $this->assertEquals($dependencies, $manifest->getDependencies());
        $this->assertEquals($providers, $manifest->getProviders());
        $this->assertEquals($aliases, $manifest->getAliases());

        $pluginPath = $manifest->getModulePath();
        $pluginPathRoot = $pluginRoot.'/'.$name;
        $pluginDatabase = $pluginPathRoot.'/database';
        $pluginMigration = $pluginDatabase.'/migrations';
        $pluginResource = $pluginPathRoot.'/resources';
        $pluginView = $pluginResource.'/views';

        $this->assertEquals($pluginPathRoot, $pluginPath->root());
        $this->assertEquals($pluginDatabase, $pluginPath->database());
        $this->assertEquals($pluginMigration, $pluginPath->migration());
        $this->assertEquals($pluginResource, $pluginPath->resource());
        $this->assertEquals($pluginView, $pluginPath->view());

        //test conversion to array
        $array = $manifest->toManifestArray();

        $this->assertEquals($array[$name]['description'],
            $manifest->getDescription());
        $this->assertEquals($array[$name]['dependencies'],
            $manifest->getDependencies());
        $this->assertEquals($array[$name]['providers'], $manifest->getProviders());
        $this->assertEquals($array[$name]['aliases'], $manifest->getAliases());
        $this->assertEquals($array[$name]['plugin_path']['migration'],
            $pluginMigration);
        $this->assertEquals($array[$name]['plugin_path']['view'],
            $pluginView);

        //test setter
        $manifest->setActive($active = $this->faker->boolean);
        $this->assertEquals($active, $manifest->getActive());
    }
}
