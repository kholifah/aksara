<?php
namespace Plugins\PostType\MediaUpload;

use Illuminate\Http\Request;

interface MediaUploadInterface
{
    public function handle(Request $request);
}

