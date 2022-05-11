<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# Controller
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

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
Route::post('login', [UserController::class, 'logi']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);

    Route::get('index', [BookController::class, 'index']);
    Route::post('store', [BookController::class, 'store']);
    Route::get('show/{id}', [BookController::class, 'show']);
    Route::put('update/{id}', [BookController::class, 'update']);
    Route::delete('destroy/{id}', [BookController::class, 'destroy']);
});
