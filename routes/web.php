<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    // public
    Route::get('/', function () {
        return view('home');
    });

    Route::get('projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');

    // dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard');

    // auth routes
    Route::middleware('auth')->group(function () {

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('messages', [MessageController::class, 'create'])->name('messages');
        Route::post('messages', [MessageController::class, 'store']);
    });

    // external route files
    require __DIR__ . '/web/auth.php';
    require __DIR__ . '/web/dashboard.php';
    require __DIR__ . '/web/freelancer.php';
    require __DIR__ . '/web/client.php';
});
