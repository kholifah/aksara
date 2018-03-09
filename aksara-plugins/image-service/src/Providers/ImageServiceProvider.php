<?php
namespace Plugins\ImageService\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\ImageService\Http\Controllers\ImageServiceController;

class ImageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $pathArray = [];

        // register assets path with depth of 10 folder
        for ($i=1;$i<=10;$i++) {
            $path = '{path_'.$i.'}';
            array_push($pathArray, $path);
            $pathRegisterRoute = implode('/', $pathArray);
            $serveImagePath = '/uploads/'.$pathRegisterRoute;
            \Route::get($serveImagePath, ImageServiceController::class . '@serve');
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Plugins\ImageService\ConfigRepository::class,
            \Plugins\ImageService\Drivers\LaravelConfig::class
        );

        $this->app->bind(
            'imageconfig',
            \Plugins\ImageService\ImageSizeConfig::class
        );

        $this->app->bind(
            'imageservice',
            \Plugins\ImageService\Resizer::class
        );

        $this->app->bind(
            \Plugins\ImageService\ImageManagerContract::class,
            \Plugins\ImageService\Drivers\Intervention::class
        );

        $this->app->bind(
            \Plugins\ImageService\FileContract::class,
            \Plugins\ImageService\Drivers\LaravelFile::class
        );

        $this->app->bind(
            \Intervention\Image\ImageManager::class,
            function () {
                return new \Intervention\Image\ImageManager(array('driver' => 'gd'));
            }
        );
    }
}
