<?php

use App\Http\Controllers\Controller;
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

Route::get('/twoNumbss', [Controller::class, 'twoNumbs']);
Route::get('/letters', [Controller::class, 'letters']);
Route::post('/toZero', [Controller::class, 'toZero']);

Route::prefix('admin')->group(function(){
    Route::post('/register', [Controller::class, 'register']);
    Route::post('/login', [Controller::class, 'login']);
    Route::middleware('auth:api')->group(function(){
        Route::get('/showUser/{id}', [Controller::class, 'showUser']);
        Route::get('/getUsers', [Controller::class, 'getUsers']);
        Route::put('/update/{id}', [Controller::class, 'updateUser']);
        Route::delete('/delete/{id}', [Controller::class, 'deleteUser']);
    });
});
