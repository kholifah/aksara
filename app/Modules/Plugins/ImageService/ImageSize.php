<?php
namespace App\Modules\Plugins\ImageService;

class ImageSize
{
    private $name;
    private $width;
    private $height;
    private $crop;
    private $aspectRatio;

    public function __construct(
        $name,
        $width = 0,
        $height = 0,
        $crop = false,
        $aspectRatio = false
    ){
        $this->name = aksara_slugify($name);
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
        $this->aspectRatio = $aspectRatio;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWidth()
    {
        if ($this->width == 0 || $this->width == false) {
            return $this->aspectRatio == true ? null : 9000;
        }
        return $this->width;
    }

    public function getHeight()
    {
        if ($this->height == 0 || $this->height == false) {
            return $this->aspectRatio == true ? null : 9000;
        }
        return $this->height;
    }

    public function getCrop()
    {
        return $this->crop;
    }

    public function getAspectRatio()
    {
        return $this->aspectRatio;
    }

    public static function fromArray(string $name, array $values) : self
    {
        return new static(
            $name,
            $values['width'],
            $values['height'],
            $values['crop'],
            $values['aspect_ratio']
        );
    }

    public function toArray() : array
    {
        return [
            $this->name => [
                'width' => $this->width,
                'height' => $this->height,
                'crop' => $this->crop,
                'aspect_ratio' => $this->aspectRatio,
            ]
        ];
    }
}
