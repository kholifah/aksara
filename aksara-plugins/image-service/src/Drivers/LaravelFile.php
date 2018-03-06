<?php
namespace Plugins\ImageService\Drivers;

use Plugins\ImageService\FileContract;
use Illuminate\Filesystem\Filesystem;

class LaravelFile implements FileContract
{
    private $file;

    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }

    public function extension($path)
    {
        return $this->file->extension($path);
    }
}
