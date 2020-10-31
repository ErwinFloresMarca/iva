<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::apiResource('autorizaciones','AutorizacionController');

Route::apiResource('proveedor','ProveedorController');
Route::post('/user/upload_avatar/{user}','UserController@uploadAvatar');
Route::apiResource('user','UserController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
