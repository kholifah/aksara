<?php

\Eventy::addAction('aksara.routes.admin', function () {
    \Route::get('/', ['as' => 'admin.root', 'uses' => '\App\Aksara\Core\Dashboard\Http\DashboardController@index']);
});
