<?php
namespace Aksara\Providers;

use Illuminate\Support\ServiceProvider;
use Aksara\Http\InputFactory;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('html_input_factory',
            \Aksara\Html\InputFactory::class
        );
    }
}

