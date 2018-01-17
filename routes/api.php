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

Route::get('/list', 'PostController@index');
Route::post('/post', 'PostController@store');
Route::get('/postlist', 'PostController@getPost');
// Route::get('/post', function () {
//     //return view('welcome');
//     echo "arif";
// }); getPost