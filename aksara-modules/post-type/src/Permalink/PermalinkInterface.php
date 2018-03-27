<?php

namespace Plugins\PostType\Permalink;

interface PermalinkInterface
{
    public function getOptions();
    public function getPermalink($post);
    public function getPostPermalinkRoutes($postType);
    public function getPostPermalinkFormat($postType);

    public function generatePostPermalinkRoutes();
    public function generatePostArchivePermalinkRoutes();
    public function generateSearchRoute();
    public function generateHomeRoute();
    public function generateCatchAll();

    public function boot();
}
