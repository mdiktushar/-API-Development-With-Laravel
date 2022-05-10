<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CurseController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware'=>['auth:api']], function () {
    # code...
    Route::get('profile', [UserController::class, 'profile']);
    Route::put('update', [UserController::class, 'update']);
    Route::get('logout', [UserController::class, 'logout']);
   
   
    Route::get('index', [CurseController::class, 'index']);
    Route::post('store', [CurseController::class, 'store']);
    Route::get('show/{id}', [CurseController::class, 'show']);
    Route::put('update/{id}', [CurseController::class, 'update']);
    Route::delete('destroy/{id}', [CurseController::class, 'destroy']);
});
