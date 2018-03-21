<?php
namespace Plugins\ImageService;

class ImagePath
{
    private $publicPath;
    private $originalPath;
    private $size;

    private function __construct(
        string $publicPath,
        string $originalPath,
        Size $size
    ){
        $this->publicPath = $publicPath;
        $this->originalPath = $originalPath;
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public static function fromUrlPath(string $publicPath)
    {
        // Check if it is registered image
        preg_match("/([0-9]*)x([0-9]*)(.*)\./", $publicPath, $matches);

        // not a custom image size pattern
        if(!isset($matches[0])) {
            return false;
        }

        $pathExtraPart = $matches[0];

        $trail = $matches[3];
        if (!empty($trail)) {
            return false;
        }

        $originalPath = str_replace("-{$pathExtraPart}", ".", $publicPath);

        $sizeStr = str_replace(".","",$matches[0]);
        $size = Size::fromSizeStr($sizeStr);

        return new static(
            $publicPath,
            $originalPath,
            $size
        );
    }

    public function getPublicPath()
    {
        return $this->publicPath;
    }

    public function getOriginalPath()
    {
        return $this->originalPath;
    }
}
