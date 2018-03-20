<?php

use Aksara\ModuleStatus\Interactor;
use Faker\Factory as Faker;
use Aksara\Repository\ConfigRepository;
use Aksara\Repository\OptionRepository;
use Aksara\ModuleStatusInfo;
use Aksara\ModuleRegistry\ModuleRegistryHandler;

class ModuleStatusInteractorTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    protected function setup()
    {
        $this->faker = Faker::create();
    }

    private function generateModuleNames()
    {
        $plugin_1 = 'plugin/'.$this->faker->slug;
        $plugin_2 = 'plugin/'.$this->faker->slug;
        $plugin_3 = 'front-end/'.$this->faker->slug;

        return array($plugin_1, $plugin_2, $plugin_3);
    }

    private function generateModules($names = [])
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
            ];
        }
        return $modules;
    }

    /** @test */
    public function shouldGetStatusPluginV2()
    {
        $configRepo = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $optionRepo = $this->getMockBuilder(OptionRepository::class)
            ->getMock();

        $pluginRegistry = $this->getMockBuilder(ModuleRegistryHandler::class)
            ->getMock();

        $plugin_1 = 'plugin/'.$this->faker->slug;
        $plugin_2 = 'plugin/'.$this->faker->slug;
        $plugin_3 = 'plugin/'.$this->faker->slug;

        $registeredModules = $this->generateModules([
            $plugin_1,
            $plugin_2,
            $plugin_3,
        ]);

        list ($registeredType, $registeredName) = explode('/', $plugin_1);

        $pluginRegistry->expects($this->any())
            ->method('isRegistered')
            ->with($registeredName)
            ->willReturn(true);

        $key = array_rand($registeredModules['plugin']);
        $activeModule = $registeredModules['plugin'][$key];

        $pluginRegistry->expects($this->once())
            ->method('isActive')
            ->with($activeModule['name'])
            ->willReturn(true);

        $interactor = new Interactor($configRepo, $optionRepo, $pluginRegistry);

        $this->assertTrue($interactor->isRegistered(
            'plugin', $registeredName));

        $this->assertTrue($interactor->isActive(
            'plugin', $activeModule['name']));

        $this->assertEquals(2, $interactor->getVersion(
            'plugin', $registeredName));
    }

    /** @test */
    public function shouldGetStatusV1()
    {
        $configRepo = $this->getMockBuilder(ConfigRepository::class)
            ->getMock();

        $optionRepo = $this->getMockBuilder(OptionRepository::class)
            ->getMock();

        $pluginRegistry = $this->getMockBuilder(ModuleRegistryHandler::class)
            ->getMock();

        $moduleNames = $this->generateModuleNames();
        $registeredModules = $this->generateModules($moduleNames);

        $configRepo->expects($this->any())
            ->method('get')
            ->willReturnCallback(function ($name, $default) use (
                $registeredModules) {
                switch ($name) {
                case 'aksara.modules': return $registeredModules;
                case 'aksara.module_manager.load_all': return false;
                default: return null;
                }
            }
        );

        $activeTypes = array_rand($registeredModules, 2);

        $activeModules = [];

        foreach ($registeredModules as $type => $module) {
            if (in_array($type, $activeTypes)) {
                foreach ($module as $name => $details) {
                    $activeModules[$type][] = $name;
                }
            }
        }

        $optionRepo->expects($this->once())
            ->method('getOptions')
            ->with('aksara.modules.actives', [])
            ->willReturn($activeModules);

        $pluginRegistry->expects($this->any())
            ->method('isRegistered')
            ->willReturn(false);

        $interactor = new Interactor($configRepo, $optionRepo, $pluginRegistry);

        list ($registeredType, $registeredName) = explode('/', $moduleNames[0]);

        $activeType = $activeTypes[array_rand($activeTypes, 1)];
        $activeModule = $activeModules[$activeType][0];
        $info = $interactor->getStatus(
            $activeType, $activeModule);

        $this->assertTrue($info->getIsRegistered());
        $this->assertTrue($info->getIsActive());
        $this->assertEquals(1, $info->getVersion());
        $this->assertEquals($activeType, $info->getType());
        $this->assertEquals($activeModule, $info->getModuleName());

    }
}
