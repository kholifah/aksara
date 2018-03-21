<?php
namespace Aksara\AssetRegistry;

interface AssetRendererIntereface
{
    public function renderScript($location);
    public function renderStyle($location);
}
