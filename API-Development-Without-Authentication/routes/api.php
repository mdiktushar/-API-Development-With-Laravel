<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\ApiController;

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

// API Phase 1
Route::post('create-employee', [ApiController::class, 'createEmployee']);
Route::get('list-employees', [ApiController::class, 'listEmployee']);
Route::get('single-employee/{id}', [ApiController::class, 'getSingleEmployee']);
Route::put('update-employee/{id}', [ApiController::class, 'updateEmployee']);
Route::delete('delete-employee/{id}', [ApiController::class, 'deleteEmployee']);
