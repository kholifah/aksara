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
            \App\Modules\Plugins\ImageService\Facades\ImageConfig::class,
            \App\Modules\Plugins\ImageService\ImageSizeConfig::class
        );
    }
}
