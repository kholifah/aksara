<?php
/*
  |------------------------------------------------------------------------
  | Load Aksara
  |------------------------------------------------------------------------
  |
 */
// if (\Schema::hasTable('options')) {
//     require_once(app_path('Aksara/Core/core.php'));
// }

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

use Illuminate\Http\Request;

Route::get('/error-fallback', function (Request $request) {
    return view('errors.fallback', $request->all());
});

Auth::routes();