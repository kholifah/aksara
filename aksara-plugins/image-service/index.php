<?php

use Plugins\ImageService\Http\Controllers\ImageServiceController;

\Eventy::addAction('aksara.init', function () {
    $pathArray = [];

    // register assets path with depth of 10 folder
    for ($i=1;$i<=10;$i++) {
        $path = '{path_'.$i.'}';
        array_push($pathArray, $path);
        $pathRegisterRoute = implode('/', $pathArray);
        $serveImagePath = '/uploads/'.$pathRegisterRoute;
        \Route::get($serveImagePath, ImageServiceController::class . '@serve');
    }
});
