<?php

namespace Plugins\PostType\Post;

interface PostInterface
{
    public function boot();

    public function registerPostType($postType, $args);
    public function registerTaxonomy($taxonomy, $postTypes = [], $args);
    public function addPostTypeToTaxonomy($taxonomy, $postType);
    public function getCurrentPostType();

    public function getPostTypeFromRoute($delimiter = false);
    public function getTaxonomyFromRoute($delimiter = false);
    public function getPostTypeArgs($key = false);
    public function getCurrentTaxonomy();
    public function getTaxonomyFromSlug($taxonomy);
    public function getTaxonomyArgs($taxonomy = false);
}
