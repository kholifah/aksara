<?php
namespace Aksara\Providers;

use Illuminate\Support\ServiceProvider;
use Aksara\AssetRegistry\AssetLocation;
use Aksara\AssetRegistry\AssetType;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Aksara\AssetRegistry\AssetRendererInterface::class,
            \Aksara\AssetRegistry\RenderInteractor::class
        );

        $this->app->bind(
            \Aksara\AssetRegistry\AssetQueueInterface::class,
            \Aksara\AssetRegistry\QueueInteractor::class
        );

        $this->app->bind('asset_queue',
            \Aksara\AssetRegistry\AssetQueueInterface::class
        );

        $this->app->bind('asset_renderer',
            \Aksara\AssetRegistry\AssetRendererInterface::class
        );
    }

    /**
     * Boot application services
     *
     * e.g, route, anything needs to be preload
     */
    public function boot()
    {
        //initializeAssetConfig
        $config = \Config::get('aksara.assets', []);

        $locations = AssetLocation::allValues();
        $types = AssetType::allValues();

        foreach ($locations as $location) {
            if (!isset($config[$location])) {
                $config[$location] = [];
            }

            foreach ($types as $type) {
                if (!isset($config[$location][$type])) {
                    $config[$location][$type] = [];
                }
            }
        }

        \Config::set('aksara.assets', $config);

        //registerAction
        //TODO replace app->make to use new renderer interface
        \Eventy::addAction('aksara.admin.head', function () {
            \AssetRenderer::renderStyle('admin');
        });
        \Eventy::addAction('aksara.admin.head', function () {
            \AssetRenderer::renderScript('admin');
        });
        \Eventy::addAction('aksara.admin.footer', function () {
            \AssetRenderer::renderScript('admin-footer');
        });
        \Eventy::addAction('aksara.front-end.head', function () {
            \AssetRenderer::renderStyle('front-end');
        });
        \Eventy::addAction('aksara.front-end.head', function () {
            \AssetRenderer::renderScript('front-end');
        });
        \Eventy::addAction('aksara.front-end.footer', function () {
            \AssetRenderer::renderScript('front-end-footer');
        });
    }
}
