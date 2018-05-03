<?php
namespace Aksara\AssetRegistry;

interface AssetRendererIntereface
{
    public function renderInlineScript($location);
    public function renderScript($location);
    public function renderStyle($location);
}
