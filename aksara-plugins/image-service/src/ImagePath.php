<?php
namespace Plugins\ImageService;

class ImagePath
{
    private $storagePath;
    private $originalPath;
    private $size;

    private function __construct(
        string $storagePath,
        string $originalPath,
        Size $size
    ){
        $this->storagePath = $storagePath;
        $this->originalPath = $originalPath;
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public static function fromUrlPath(string $urlPath)
    {
        // Check if it is registered image
        preg_match("/([0-9]*)x([0-9]*)(.*)\./", $urlPath, $matches);

        // not a custom image size pattern
        if(!isset($matches[0])) {
            return false;
        }

        $pathExtraPart = $matches[0];

        $trail = $matches[3];
        if (!empty($trail)) {
            return false;
        }

        $originalPath = base_path()
            .'/public/'
            . str_replace("-{$pathExtraPart}", ".", $urlPath);

        $storagePath = base_path().'/public/' . $urlPath;

        $sizeStr = str_replace(".","",$matches[0]);
        $size = Size::fromSizeStr($sizeStr);

        return new static(
            $storagePath,
            $originalPath,
            $size
        );
    }

    public function getStoragePath()
    {
        return $this->storagePath;
    }

    public function getOriginalPath()
    {
        return $this->originalPath;
    }
}
