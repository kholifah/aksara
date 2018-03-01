<?php
namespace App\Modules\Plugins\ImageService\Providers;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //potentially confusing with aksara's module loading sequence
        //don't boot anything here
        //leave it empty or don't create the method at all
        //boot anything necessary in index.php
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Modules\Plugins\ImageService\ConfigRepository::class,
            \App\Modules\Plugins\ImageService\Drivers\LaravelConfig::class
        );

        $this->app->bind(
            \App\Modules\Plugins\ImageService\Facades\ImageConfig::class,
            \App\Modules\Plugins\ImageService\ImageSizeConfig::class
        );

        $this->app->bind(
            \App\Modules\Plugins\ImageService\Facades\ImageService::class,
            \App\Modules\Plugins\ImageService\Resizer::class
        );

        $this->app->bind(
            \App\Modules\Plugins\ImageService\ImageManagerContract::class,
            \App\Modules\Plugins\ImageService\Drivers\Intervention::class
        );

        $this->app->bind(
            \Intervention\Image\ImageManager::class,
            function () {
                return new \Intervention\Image\ImageManager(array('driver' => 'gd'));
            }
        );
    }
}
