<?php

use App\Http\Controllers\Api\AuthTokensController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Middleware\CheckApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['checkApiKey']], function () {

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('projects', ProjectsController::class)->middleware('auth:sanctum');

    Route::get('auth/tokens', [AuthTokensController::class, 'index'])->middleware('auth:sanctum');
    Route::post('auth/tokens', [AuthTokensController::class, 'store'])->middleware('guest:sanctum'); // should not be the users is login
    Route::delete('auth/tokens/{id}', [AuthTokensController::class, 'destroy'])->middleware('auth:sanctum');
});
