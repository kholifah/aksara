<?php

namespace Plugins\PostType\MetaboxRegistry;

interface MetaboxRegistryInterface
{
    public function boot();
    public function add(string $id, string $postType,
        $callbackRender = null, $callbackSave = null,
        string $location = "metabox", $priority = 10);
    public function addClass(MetaboxBase $metabox);
}
