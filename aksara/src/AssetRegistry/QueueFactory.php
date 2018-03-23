<?php

namespace Aksara\AssetRegistry;

class QueueFactory
{
    private $queue;

    public function __construct(AssetQueueInterface $queue)
    {
        $this->queue = $queue;
    }

    public function enqueue()
    {
        if (is_null($this->location)) {
            throw new \Exception('Location must be set');
        }

        if (is_null($this->type)) {
            throw new \Exception('Type must be set');
        }

        if (!is_null($this->url)) {
            $this->queue->enqueue(
                $this->location,
                $this->type,
                $this->url,
                $this->id ?? false,
                $this->priority ?? 20,
                $this->footer ?? false
            );
            return;
        }

        if (is_null($this->module)) {
            throw new \Exception('Module must be set');
        }

        if (is_null($this->assetPath)) {
            throw new \Exception('Asset Path must be set');
        }

        $this->queue->enqueueModuleAsset(
            $this->location,
            $this->type,
            $this->module,
            $this->assetPath,
            $this->id ?? false,
            $this->priority ?? 20,
            $this->footer ?? false
        );
    }

    /**
     * parameters
     */
    private $location;
    private $type;
    private $module;
    private $assetPath;
    private $url;
    private $id;
    private $priority;
    private $footer;

    public function url($url) : self
    {
        $this->module = null;
        $this->assetPath = null;

        $this->url = $url;
        return $this;
    }

    public function id($id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function priority($priority) : self
    {
        $this->priority = $priority;
        return $this;
    }

    public function footer($footer) : self
    {
        $this->footer = $footer;
        return $this;
    }

    public function module($module) : self
    {
        $this->url = null;

        $this->module = $module;
        return $this;
    }

    public function assetPath($assetPath) : self
    {
        $this->url = null;

        $this->assetPath = $assetPath;
        return $this;
    }

    public function frontend() : self
    {
        $this->location = AssetLocation::frontend();
        return $this;
    }

    public function admin() : self
    {
        $this->location = AssetLocation::admin();
        return $this;
    }

    public function adminFooter() : self
    {
        $this->location = AssetLocation::adminFooter();
        return $this;
    }

    public function frontendFooter() : self
    {
        $this->location = AssetLocation::frontendFooter();
        return $this;
    }

    public function script() : self
    {
        $this->type = AssetType::script();
        return $this;
    }

    public function style() : self
    {
        $this->type = AssetType::style();
        return $this;
    }
}
