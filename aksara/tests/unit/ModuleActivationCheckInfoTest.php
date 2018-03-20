<?php

use Aksara\ModuleActivationCheckInfo;
use Aksara\ModuleStatusInfo;
use Aksara\MigrationInfo;
use Faker\Factory as Faker;

class ModuleActivationCheckInfoTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    /** @test */
    public function shouldCreateObject()
    {
        $dependency = $this->getMockBuilder(ModuleStatusInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dependency->expects($this->once())
            ->method('toArray')
            ->willReturn($dependencyArray = $this->faker->words);

        $migration = $this->getMockBuilder(MigrationInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $migration->expects($this->once())
            ->method('getPath')
            ->willReturn(
                $migrationPath = $this->faker->word.'/'.$this->faker->slug);

        $migration->expects($this->any())
            ->method('__toString')
            ->willReturn(
                $migrationString = $this->faker->sentence);

        $info = new ModuleActivationCheckInfo(
            $type = $this->faker->randomElement([ 'plugin', 'front-end', 'core' ]),
            $moduleName = $this->faker->slug,
            $dependencies = [ $dependency ],
            $migrations = [ $migration ]
        );

        $this->assertEquals($type, $info->getType());
        $this->assertEquals($moduleName, $info->getModuleName());
        $this->assertEquals($dependencies, $info->getDependencies());
        $this->assertEquals($migrations, $info->getMigrations());
        $this->assertFalse($info->allowActivation());

        $array = $info->toArray();

        $this->assertEquals($type, $array['type']);
        $this->assertEquals($moduleName, $array['module_name']);
        $this->assertEquals([ $dependencyArray ], $array['dependencies']);
        $this->assertEquals([ $migrationString ], $array['migrations']);
        $this->assertEquals([ $migrationPath ], $array['migration_paths']);
        $this->assertFalse($array['allow_activation']);
    }

    /** @test */
    public function shouldDisallowUnregistered()
    {
        $dependency = $this->getMockBuilder(ModuleStatusInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dependency->expects($this->once())
            ->method('getIsRegistered')
            ->willReturn(false);

        $info = new ModuleActivationCheckInfo(
            $type = $this->faker->randomElement([ 'plugin', 'front-end', 'core' ]),
            $moduleName = $this->faker->slug,
            $dependencies = [ $dependency ],
            $migrations = []
        );

        $this->assertFalse($info->allowActivation());
    }

    /** @test */
    public function shouldAllowActivation()
    {
        $dependency = $this->getMockBuilder(ModuleStatusInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dependency->expects($this->once())
            ->method('getIsRegistered')
            ->willReturn(true);

        $info = new ModuleActivationCheckInfo(
            $type = $this->faker->randomElement([ 'plugin', 'front-end', 'core' ]),
            $moduleName = $this->faker->slug,
            $dependencies = [ $dependency ],
            $migrations = []
        );

        $this->assertTrue($info->allowActivation());
    }
}
