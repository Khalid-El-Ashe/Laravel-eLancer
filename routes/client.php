<?php

use App\Http\Controllers\Client\ProjectController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'client',
    'as' => 'client.',
    'middleware' => ['auth']
], function () {

    Route::resource('projects', ProjectController::class);
    // Route::resource('messages', MessageController::class);
});

// Route::resource('projects', ProjectController::class)->names([
//     'index'=> 'client.project.index',
//     'create'=> 'client.project.create',
// ]);
