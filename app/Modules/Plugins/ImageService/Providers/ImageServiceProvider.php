<?php
namespace App\Modules\Plugins\ImageService\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Plugins\ImageService\ImageSizeConfig;

class ImageServiceProvider extends ServiceProvider
{
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
