<?php

\Eventy::addAction('aksara.routes.before', function () {
    $pathArray = [];

    // register assets path with depth of 10 folder
    for ($i=1;$i<=10;$i++) {
        $path = '{path_'.$i.'}';

        array_push($pathArray, $path);

        $pathRegisterRoute = implode('/', $pathArray);

        Route::get('/assets/modules/{module_type}/{module_name}/'.$pathRegisterRoute, '\App\Aksara\Core\Asset\Http\StaticFileController@serveV1');
        Route::get('/assets/modules-v2/{module_name}/'.$pathRegisterRoute, '\App\Aksara\Core\Asset\Http\StaticFileController@serveV2');
    }
});
