<?php

use Aksara\ModuleDependency\PluginRequiredByInteractor as Interactor;
use Faker\Factory as Faker;
use Aksara\ModuleKey;
use Aksara\Repository\ConfigRepository;
use Aksara\ModuleStatus\ModuleStatus;
use Aksara\PluginRegistry\PluginRegistryHandler;
use Aksara\PluginRegistry\PluginManifest;

class PluginRequiredByInteractorTest extends PHPUnit\Framework\TestCase
{
    private $faker;
    private $pluginName;

    protected function setup()
    {
        $this->faker = Faker::create();
        $this->pluginName = $this->faker->slug;
    }

    private function generateModuleNames()
    {
        $plugin_1 = 'plugin/'.$this->faker->slug;
        $plugin_2 = 'plugin/'.$this->faker->slug;
        $plugin_3 = 'front-end/'.$this->faker->slug;

        return array($plugin_1, $plugin_2, $plugin_3);
    }

    private function generateModulesV1($names = [])
    {
        if (empty($names)) {
            $names = $this->generateModuleNames();
        }

        $modules = [];
        foreach ($names as $name) {
            $split = explode('/', $name);
            $modules[$split[0]][$split[1]] = [
                'name' => $split[1],
                'description' => $this->faker->sentence,
                'dependencies' => [ $this->pluginName ],//TODO
            ];
        }
        return $modules;
    }

    /** @test */
    public function shouldGetRequiredByV1()
    {
        $configRepo = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $moduleStatus = $this->getMockBuilder(ModuleStatus::class)
            ->getMock();

        $pluginRegistry = $this->getMockBuilder(PluginRegistryHandler::class)
            ->getMock();

        $pluginRegistry->expects($this->exactly(2))
            ->method('getActivePlugins')
            ->willReturn([]);

        $moduleStatus->expects($this->any())
            ->method('isActive')
            ->willReturn(true);

        $modules_v1 = $this->generateModulesV1();

        $configRepo->expects($this->exactly(2))
            ->method('get')
            ->with('aksara.modules')
            ->willReturn($modules_v1);

        $interactor = new Interactor(
            $configRepo,
            $moduleStatus,
            $pluginRegistry
        );

        $requiredBy = $interactor->getRequiredBy($this->pluginName);

        foreach ($requiredBy as $required) {
            $found = false;
            foreach ($modules_v1 as $key => $value) {
                foreach ($value as $subKey => $detail) {
                    if ($required->getModuleName() == $subKey) {
                        $found = true;
                        break;
                    }
                }
                if ($found) break;
            }
            $this->assertTrue($found);
        }

        $this->assertTrue($interactor->isRequired($this->pluginName));
    }

    /** @test */
    public function shouldGetRequiredByV2()
    {
        $configRepo = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $moduleStatus = $this->getMockBuilder(ModuleStatus::class)
            ->getMock();

        $pluginRegistry = $this->getMockBuilder(PluginRegistryHandler::class)
            ->getMock();

        $plugin = $this->getMockBuilder(PluginManifest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $plugin->expects($this->once())
            ->method('getDependencies')
            ->willReturn([ $this->pluginName ]);

        $plugin->expects($this->once())
            ->method('getName')
            ->willReturn($dependentName = $this->faker->slug);

        $activePlugins = [
            $plugin,
        ];

        $pluginRegistry->expects($this->once())
            ->method('getActivePlugins')
            ->willReturn($activePlugins);

        $configRepo->expects($this->once())
            ->method('get')
            ->with('aksara.modules')
            ->willReturn([]);
        $interactor = new Interactor(
            $configRepo,
            $moduleStatus,
            $pluginRegistry
        );

        $requiredBy = $interactor->getRequiredBy($this->pluginName);

        $requiredByItem = $requiredBy[0];

        $this->assertEquals('plugin', $requiredByItem->getType());
        $this->assertEquals($dependentName, $requiredByItem->getModuleName());
    }
}
