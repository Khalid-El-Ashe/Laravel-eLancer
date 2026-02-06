<?php

namespace Routes\Web;

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'dashboard/',
    // 'namespace' => 'App\Http\Controllers\Dashboard',
    'middleware' => ['auth'],
    // 'middleware' => ['auth:admin'],
    // 'as' => 'categories.',
    // 'middleware' => ''
], function () {
    // Route::resource('categories', CategoriesController::class);


    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/', [CategoriesController::class, 'store'])->name('store');

        Route::get('/trash', [CategoriesController::class, 'trash'])->name('trash');

        Route::get('/{category}', [CategoriesController::class, 'show'])->name('show');
        #todo optional parameter by (?)
        // Route::get('/categories/{$category?}', [CategoriesController::class, 'show']);
        Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoriesController::class, 'update'])->name('update');

        Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('destroy');

        Route::put('/trash/{category}/restore', [CategoriesController::class, 'restore'])->name('restore');
        Route::delete('/trash/{category}', [CategoriesController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::get('profile', function () {
        return 'Secret Profile';
    })->middleware('password.confirm');
    // Route::get('categories', [CategoriesController::class, 'index'])->name('index');
    // Route::get('categories/create', [CategoriesController::class, 'create'])->name('create');
    // Route::post('categories', [CategoriesController::class, 'store'])->name('store');
    // Route::get('categories/{id}', [CategoriesController::class, 'show'])->name('show');
    // #todo optional parameter by (?)
    // // Route::get('/categories/{id?}', [CategoriesController::class, 'show']);
    // Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
    // Route::put('categories/{id}', [CategoriesController::class, 'update'])->name('update');
    // Route::delete('categorie/{id}', [CategoriesController::class, 'destroy'])->name('destroy');

});
