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
    // create user with unique account
    Route::post('create','\App\Http\Controllers\api\UserController@store');
//    Route::post('create', function () {
//        return 'Hello,';
//    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
