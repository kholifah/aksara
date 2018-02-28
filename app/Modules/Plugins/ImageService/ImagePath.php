<?php
namespace App\Modules\Plugins\ImageService;

class ImagePath
{
    private $storagePath;
    private $originalPath;
    private $requestWidth;
    private $requestHeight;

    private function __construct(
        string $storagePath,
        string $originalPath,
        int $requestWidth,
        int $requestHeight
    ){
        $this->storagePath = $storagePath;
        $this->originalPath = $originalPath;
        $this->requestWidth = $requestWidth;
        $this->requestHeight = $requestHeight;
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

        $matches = str_replace(".","",$matches[0]);
        $matches = explode("x", $matches);

        $width = $matches[0];
        $height = $matches[1];

        return new static($storagePath, $originalPath, $width, $height);
    }

    public function getStoragePath()
    {
        return $this->storagePath;
    }

    public function getOriginalPath()
    {
        return $this->originalPath;
    }

    public function getRequestWidth()
    {
        return $this->requestWidth;
    }

    public function getRequestHeight()
    {
        return $this->requestHeight;
    }
}
