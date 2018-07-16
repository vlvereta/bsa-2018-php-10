<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Needed for test! Delete later.
 */
Route::get('/currencies', function () {
    factory(\App\Entity\Currency::class, 5)->create();
    return json_encode(\App\Entity\Currency::all()->toArray());
});

Route::put('/currencies/{id}/rate', 'ApiController@update');


