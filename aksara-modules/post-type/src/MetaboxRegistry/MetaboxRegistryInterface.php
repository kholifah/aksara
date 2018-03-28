<?php

namespace Plugins\PostType\MetaboxRegistry;

interface MetaboxRegistryInterface
{
    public function boot();
    public function add(string $id, string $postType,
        string $callbackRender = null, string $callbackSave = null,
        string $location = "metabox", $priority = 10);
}
