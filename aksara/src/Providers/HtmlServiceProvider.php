<?php
namespace Aksara\Providers;

use Illuminate\Support\ServiceProvider;
use Aksara\Http\FieldFactory;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('field_factory',
            \Aksara\Html\FieldFactory::class
        );
    }
}

