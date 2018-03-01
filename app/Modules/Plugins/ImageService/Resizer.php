<?php
namespace App\Modules\Plugins\ImageService;

class Resizer
{
    private $imgManager;
    private $imgConfig;

    public function __construct(
        ImageManagerContract $imgManager,
        ImageSizeConfig $imgConfig
    ){
        $this->imgManager = $imgManager;
        $this->imgConfig = $imgConfig;
    }

    public function resize(string $urlPath)
    {
        $imgPath = ImagePath::fromUrlPath($urlPath);

        if (!$imgPath) {
            return false;
        }

        // Check original file exist
        if( !file_exists($imgPath->getOriginalPath()) ) {
            return false;
        }

        $config = $this->imgConfig->getRegisteredImage(
            $imgPath->getSize()
        );

        if (!$config) {
            return false;
        }

        if (!$this->createResizedImage($imgPath, $config)) {
            return false;
        }

        return $urlPath;
    }

    private function createResizedImage($imgPath, $config)
    {
        try {
            $image = $this->imgManager->make($imgPath->getOriginalPath());

            if (!$image) {
                return false;
            }

            if ($config->getAspectRatio()) {
                $image->resize(
                    $config->getWidth(),
                    $config->getHeight(),
                    function($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
            }
            elseif ($config->getCrop()) {
                $image->fit(
                    $config->getWidth(),
                    $config->getHeight(),
                    function($constraint) {
                        $constraint->upsize();
                    });
            }
            else {
                $image->crop(
                    $config->getWidth(),
                    $config->getHeight(),
                    function($contsraint) {
                        $constraint->aspectRatio();
                    });
            }

            $image->save($imgPath->getStoragePath());

            return true;
        }
        catch (\Exception $e) {
            throw new \Exception("Image resize failed : $e");
        }
    }
}

