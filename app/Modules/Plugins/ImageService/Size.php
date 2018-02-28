<?php
namespace App\Modules\Plugins\ImageService;

class Size
{
    private $width;
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public static function fromSizeStr(string $sizeStr)
    {
        $sizes = explode("x", $sizeStr);

        return new static(
            $sizes[0],
            $sizes[1]
        );
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }
}
