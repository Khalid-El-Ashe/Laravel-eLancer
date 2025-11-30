<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::group([
    'prefix' => 'dashboard/',
    // 'as' => 'categories.',
    // 'middleware' => ''
], function () {
    Route::resource('categories', CategoriesController::class);
    

    // Route::prefix('categories')->group(function () {
    // Route::get('/', [CategoriesController::class, 'index'])->name('index');
    // Route::get('/create', [CategoriesController::class, 'create'])->name('create');
    // Route::post('/', [CategoriesController::class, 'store'])->name('store');
    // Route::get('/{$category}', [CategoriesController::class, 'show'])->name('show');
    // #todo optional parameter by (?)
    // // Route::get('/categories/{$category?}', [CategoriesController::class, 'show']);
    // Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('edit');
    // Route::put('/{category}', [CategoriesController::class, 'update'])->name('update');
    // Route::delete('/{$category}', [CategoriesController::class, 'destroy'])->name('destroy');
    // });

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
