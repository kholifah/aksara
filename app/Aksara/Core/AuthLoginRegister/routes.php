<?php

\Eventy::addAction('aksara.routes.front_end', function () {
    $loginRoute = Eventy::filter('aksara.route.login', 'auth/login');
    $registerRoute = Eventy::filter('aksara.route.register', 'auth/register');

    // Authentication routes
    \Route::get($loginRoute, ['as' => 'admin.login', 'uses' =>'\App\Aksara\Core\AuthLoginRegister\Http\AuthController@login']);
    \Route::post($loginRoute, ['as' => 'admin.doLogin', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@authenticate']);
    \Route::get('auth/logout', ['as' => 'admin.logout', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@logout']);

    // Registration routes...
    // \Route::get($registerRoute, ['as' => 'register', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@register']);
    // \Route::post($registerRoute, ['as' => 'doRegister', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@doRegister']);
    // \Route::get('/registration/activate/{code}', ['as' => 'activate', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@activate']);
    //
    // // Password reset link request routes...
    // \Route::get('password/email', ['as' => 'password_reset', 'uses' => '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@getEmail']);
    // \Route::post('password/email', '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@postEmail');
    //
    // // Password reset routes...
    // \Route::get('password/reset/{token}', '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@getReset');
    // \Route::post('password/reset', '\App\Aksara\Core\AuthLoginRegister\Http\AuthController@postReset');
});
