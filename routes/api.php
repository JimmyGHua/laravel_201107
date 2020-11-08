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

Route::prefix('v1/user')->group(function () {
    // create user with password and unique account
    Route::post('create','\App\Http\Controllers\api\UserController@store');
    // delete member with given account
    Route::post('delete','\App\Http\Controllers\api\UserController@destroy');
    // update password with given account
    Route::post('pwd/change','\App\Http\Controllers\api\UserController@update');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
