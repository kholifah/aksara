<?php

use Aksara\PluginRegistry\Interactor;
use Aksara\AdminNotif\AdminNotifRequest;
use Aksara\AdminNotif\AdminNotifHandler;
use Aksara\Application\ApplicationInterface;
use Faker\Factory as Faker;
use Illuminate\Filesystem\Filesystem;

class PluginRegistryInteractorTest extends PHPUnit\Framework\TestCase
{
    private $faker;

    private $basePath;
    private $pluginRoot;
    private $activePath;
    private $app;

    protected function setup()
    {
        $this->faker = Faker::create();

        $this->basePath = $this->generateDir($this->faker->slug);
        $this->pluginRoot = $this->basePath."/aksara-plugins";
        $this->activePath = $this->pluginRoot."/active_manifest.php";

        $this->app = $this->getMockBuilder(ApplicationInterface::class)
            ->getMock();

        $this->app->expects($this->once())
            ->method('basePath')
            ->with('aksara-plugins')
            ->willReturn($this->pluginRoot);
    }

    private function generateDir($lastDir)
    {
        return $this->faker->word.'/'.$this->faker->word.'/'.$lastDir;
    }

    private function getRegisteredPluginNames()
    {
        $plugin_1 = $this->faker->slug;
        $plugin_2 = $this->faker->slug;
        $plugin_3 = $this->faker->slug;

        return array($plugin_1, $plugin_2, $plugin_3);
    }

    /** @test */
    public function shouldCheckIsRegistered()
    {
        $registered = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($registered);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->exactly(2))
            ->method('directories')
            ->with($this->pluginRoot)
            ->willReturn($directories);

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $this->assertTrue($interactor->isRegistered(
            $this->faker->randomElement($registered)
        ));

        $this->assertFalse($interactor->isRegistered(
            $this->faker->randomElement($registered).'_fake'
        ));

    }

    /** @test */
    public function shouldCheckIsActive()
    {
        $activePlugins = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($activePlugins);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->activePath)
            ->willReturn(true);

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use ($activePlugins) {
                return $activePlugins;
            });

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $this->assertTrue($interactor->isActive(
            $this->faker->randomElement($activePlugins)
        ));

        $this->assertFalse($interactor->isActive(
            $this->faker->randomElement($activePlugins).'_fake'
        ));

    }

    /** @test */
    public function shouldHandleManifestNotFound()
    {
        $directories = $this->getMockDirectories();

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->once())
            ->method('directories')
            ->with($this->pluginRoot)
            ->willReturn($directories);

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->logicalOr(
                $manifest1 = $directories[0].'/plugin.php',
                $manifest2 = $directories[1].'/plugin.php',
                $manifest3 = $directories[2].'/plugin.php',
                $this->activePath
            ))
            ->willReturn(false);

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $this->expectException(\Exception::class);
        $interactor->getRegisteredPlugins();
    }

    /** @test */
    public function shouldGetRegisteredPlugins()
    {
        $directories = $this->getMockDirectories();

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->once())
            ->method('directories')
            ->with($this->pluginRoot)
            ->willReturn($directories);

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->logicalOr(
                $manifest1 = $directories[0].'/plugin.php',
                $manifest2 = $directories[1].'/plugin.php',
                $manifest3 = $directories[2].'/plugin.php',
                $this->activePath
            ))
            ->willReturnCallback(function ($path) {
                if ($path == $this->activePath) {
                    return false;
                }
                return true;
            });

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use (
                $manifest1, $manifest2, $manifest3) {
                switch ($manifestPath) {
                case $manifest1: return [
                        'name' => $name_1 = $this->faker->slug,
                        'description' => $description_1 = $this->faker->sentence,
                    ];
                case $manifest2: return [
                        'name' => $name_2 = $this->faker->slug,
                        'description' => $description_2 = $this->faker->sentence,
                    ];
                case $manifest3: return [
                        'name' => $name_3 = $this->faker->slug,
                        'description' => $description_3 = $this->faker->sentence,
                    ];
                default: return null;
                }
            });

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $interactor->getRegisteredPlugins();
    }

    private function getMockDirectories($plugins = [])
    {
        list ($plugin_1, $plugin_2, $plugin_3) = empty($plugins) ?
            $this->getRegisteredPluginNames()
            : $plugins;

        $directories = [
            $pluginDir1 = $this->pluginRoot."/$plugin_1",
            $pluginDir2 = $this->pluginRoot."/$plugin_2",
            $pluginDir3 = $this->pluginRoot."/$plugin_3",
        ];
        return $directories;
    }

    /** @test */
    public function shouldGetActivePlugins()
    {
        $activePlugins = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($activePlugins);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->logicalOr(
                $manifest1 = $directories[0].'/plugin.php',
                $manifest2 = $directories[1].'/plugin.php',
                $manifest3 = $directories[2].'/plugin.php',
                $this->activePath
            ))
            ->willReturn(true);

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use (
                $manifest1, $manifest2, $manifest3, $activePlugins) {
                switch ($manifestPath) {
                case $manifest1: return [
                        'name' => $name_1 = $this->faker->slug,
                        'description' => $description_1 = $this->faker->sentence,
                    ];
                case $manifest2: return [
                        'name' => $name_2 = $this->faker->slug,
                        'description' => $description_2 = $this->faker->sentence,
                    ];
                case $manifest3: return [
                        'name' => $name_3 = $this->faker->slug,
                        'description' => $description_3 = $this->faker->sentence,
                    ];
                case $this->activePath: return $activePlugins;
                default: return null;
                }
            });

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $interactor->getActivePlugins();
    }

    /** @test */
    public function shouldActivatePlugin()
    {
        $registeredPlugins = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($registeredPlugins);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->logicalOr(
                $manifest1 = $directories[0].'/plugin.php',
                $manifest2 = $directories[1].'/plugin.php',
                $manifest3 = $directories[2].'/plugin.php',
                $this->activePath
            ))
            ->willReturn(true);

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use (
                $manifest1, $manifest2, $manifest3, $registeredPlugins) {
                switch ($manifestPath) {
                case $manifest1: return [
                        'name' => $name_1 = $this->faker->slug,
                        'description' => $description_1 = $this->faker->sentence,
                    ];
                case $manifest2: return [
                        'name' => $name_2 = $this->faker->slug,
                        'description' => $description_2 = $this->faker->sentence,
                    ];
                case $manifest3: return [
                        'name' => $name_3 = $this->faker->slug,
                        'description' => $description_3 = $this->faker->sentence,
                    ];
                case $this->activePath: return $registeredPlugins;
                default: return null;
                }
            });

        $filesystem->expects($this->any())
            ->method('isWritable')
            ->willReturn(true);

        $activated = $this->faker->slug;

        $manifestDump = var_export(array_merge($registeredPlugins, [ $activated ]), true);

        $filesystem->expects($this->once())
            ->method('put')
            ->with($this->activePath, '<?php return '.$manifestDump.';');

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $notifHandler->expects($this->once())
            ->method('handle');

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $interactor->activatePlugin($activated);

    }

    /** @test */
    public function shouldDeactivatePlugin()
    {
        $activePlugins = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($activePlugins);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->activePath)
            ->willReturn(true);

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use ($activePlugins) {
                return $activePlugins;
            });

        $filesystem->expects($this->any())
            ->method('isWritable')
            ->willReturn(true);

        $deactivated = $this->faker->randomElement($activePlugins);

        $manifestDump = var_export(
                array_diff($activePlugins, [ $deactivated ]), true);

        $filesystem->expects($this->once())
            ->method('put')
            ->with($this->activePath, '<?php return '.$manifestDump.';');

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $notifHandler->expects($this->once())
            ->method('handle');

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $interactor->deactivatePlugin($deactivated);
    }

    /** @test */
    public function shouldHandleDirectoryAccessDenied()
    {
        $activePlugins = $this->getRegisteredPluginNames();
        $directories = $this->getMockDirectories($activePlugins);

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem->expects($this->any())
            ->method('exists')
            ->with($this->activePath)
            ->willReturn(true);

        $filesystem->expects($this->any())
            ->method('getRequire')
            ->willReturnCallback(function ($manifestPath) use ($activePlugins) {
                return $activePlugins;
            });

        $filesystem->expects($this->any())
            ->method('isWritable')
            ->willReturn(false);

        $deactivated = $this->faker->randomElement($activePlugins);

        $notifHandler = $this->getMockBuilder(AdminNotifHandler::class)
            ->getMock();

        $interactor = new Interactor($this->app, $filesystem, $notifHandler);

        $this->expectException(\Exception::class);
        $interactor->deactivatePlugin($deactivated);
    }
}
