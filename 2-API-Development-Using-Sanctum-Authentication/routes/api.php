<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserInfoController;

// Middleware


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API UnAuth
Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);

// API Auth:senctum
Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get("profile", [UserController::class, 'profile']);
    Route::get("logout", [UserController::class, 'logout']);

    Route::get('users', [UserInfoController::class, 'index']);
    Route::post('store', [UserInfoController::class, 'store']);
    Route::get('view/{id}', [UserInfoController::class, 'show']);
    Route::put('update/{id}', [UserInfoController::class, 'update']);
    Route::delete('delete/{id}', [UserInfoController::class, 'destroy']);
});
