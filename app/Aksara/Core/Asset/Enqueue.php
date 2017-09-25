<?php
namespace App\Aksara\Core\Asset;

class Enqueue
{
    protected $location = ['admin','front-end','admin-footer','front-end-footer'];
    protected $type = ['script','style'];

    public function __construct()
    {
        $this->initializeAssetConfig();
        $this->registerAction();
    }

    public function registerAction()
    {
        \Eventy::addAction('aksara.admin.head', function () {
            \App::make('enqueue')->renderStyle('admin');
        });
        \Eventy::addAction('aksara.admin.head', function () {
            \App::make('enqueue')->renderScript('admin');
        });
        \Eventy::addAction('aksara.admin.footer', function () {
            \App::make('enqueue')->renderScript('admin-footer');
        });
        \Eventy::addAction('aksara.front-end.head', function () {
            \App::make('enqueue')->renderStyle('front-end');
        });
        \Eventy::addAction('aksara.front-end.head', function () {
            \App::make('enqueue')->renderScript('front-end');
        });
        \Eventy::addAction('aksara.front-end.footer', function () {
            \App::make('enqueue')->renderScript('front-end-footer');
        });
    }

    public function renderScript($location)
    {
        $config = \Config::get('aksara.assets', []);
        $enqueueScripts = $config[$location]['script'];

        // sort from priority
        ksort($enqueueScripts);

        foreach ($enqueueScripts as $position => $scripts) {
            foreach ($scripts as $script) {
                if (filter_var($script, FILTER_VALIDATE_URL)) {
                    echo '<script src="'.$script.'"></script>';
                }
            }
        }
    }

    public function renderStyle($location)
    {
        $config = \Config::get('aksara.assets', []);
        $enqueueStyles = $config[$location]['style'];

        // sort from priority
        ksort($enqueueStyles);

        foreach ($enqueueStyles as $position => $styles) {
            foreach ($styles as $style) {
                if (filter_var($style, FILTER_VALIDATE_URL)) {
                    echo '<link rel="stylesheet" type="text/css" href="'.$style.'">';
                }
            }
        }
    }

    public function initializeAssetConfig()
    {
        $config = \Config::get('aksara.assets', []);

        foreach ($this->location as $location) {
            if (!isset($config[$location])) {
                $config[$location] = [];
            }

            foreach ($this->type as $type) {
                if (!isset($config[$location][$type])) {
                    $config[$location][$type] = [];
                }
            }
        }

        \Config::set('aksara.assets', $config);
    }

    // $type = 'js' | 'css'
    // $location = 'admin' | front-end
    // $id
    // $priority
    // in footer
    public function enqueue($location, $type, $url, $id, $priority = 10, $footer=false)
    {
        if (!in_array($location, $this->location)) {
            return false;
        }

        if (!in_array($type, $this->type)) {
            return false;
        }

        if ($type == 'script' && $footer == true) {
            $location = $location.'-footer';
        }

        $config = \Config::get('aksara.assets', []);

        if (!isset($config[$location][$type][$priority])) {
            $config[$location][$type][$priority] = [];
        }

        array_push($config[$location][$type][$priority], $url);

        \Config::set('aksara.assets', $config);
    }
}
