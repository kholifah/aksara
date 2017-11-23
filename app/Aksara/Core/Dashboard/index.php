<?php

\Eventy::addAction('aksara.routes.admin', function () {
    $dashboardController = \Eventy::filter('aksara.dashboard.controller', '\App\Aksara\Core\Dashboard\Http\DashboardController@index');
    \Route::get('/', ['as' => 'admin.root', 'uses' => $dashboardController]);
});
