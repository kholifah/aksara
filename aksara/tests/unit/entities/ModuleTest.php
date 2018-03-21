<?php

use Aksara\Entities\Module;
use Faker\Factory as Faker;

class ModuleTest extends PHPUnit\Framework\TestCase
{
    private $type;
    private $key;
    private $path;
    private $name;
    private $description;
    private $dependencies;
    private $migration;

    protected function setup()
    {
        $faker = Faker::create();

        $this->type = $faker->slug;
        $this->key = $faker->slug;
        $this->path = implode('/', $faker->words(3));
        $this->name = $faker->name;

        $this->description = $faker->sentence;
        $this->dependencies = $faker->words;
        $this->migration = $faker->url;
    }

    /** @test */
    public function shouldCreateObject()
    {
        $obj = new Module(
            $this->type,
            $this->key,
            $this->path,
            $this->name,
            $this->description,
            $this->dependencies,
            $this->migration
        );

        $this->assertObject($obj);

        $this->assertEquals($this->description, $obj->getDescription());
        $this->assertEquals($this->dependencies, $obj->getDependencies());
        $this->assertEquals($this->migration, $obj->getMigration());
    }

    private function assertObject($obj)
    {
        $this->assertEquals($this->type, $obj->getType());
        $this->assertEquals($this->key, $obj->getKey());
        $this->assertEquals($this->path, $obj->getPath());
        $this->assertEquals($this->name, $obj->getName());
        $this->assertEquals($this->path . '/assets', $obj->getAssetPath());
    }

    /** @test */
    public function shouldCreateFromArray()
    {
        $configArray = [
            $this->type => [
                $this->key => [
                    'modulePath' => $this->path,
                    'name' => $this->name,
                ]
            ]
        ];

        $objects = Module::fromConfigArray($configArray);

        $this->assertCount(1, $objects);
        $this->assertObject($objects[0]);
    }

}
