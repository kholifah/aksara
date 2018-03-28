<?php

namespace Plugins\PostType\MetaboxRegistry;

abstract class MetaboxBase
{
    /**
     * Required attributes
     */
    abstract function getId();
    abstract function getPostType();
    abstract function getCallbackRender();

    /**
     * Optional attributes
     */
    public function getCallbackSave()
    {
        return null;
    }

    public function getLocation()
    {
        return 'metabox';
    }

    public function getPriority()
    {
        return 20;
    }
}
