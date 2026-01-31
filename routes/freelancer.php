<?php

use App\Http\Controllers\Freelancer\ProfileController;
use App\Http\Controllers\Freelancer\ProposalsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'freelancer',
    'as' => 'freelancer.',
    'middleware' => ['auth:web']
], function () {
    Route::get('proposals', [ProposalsController::class, 'index'])->name('proposal.index');
    Route::get('proposals/{project}', [ProposalsController::class, 'create'])->name('proposal.create');
    Route::post('proposals/{project}', [ProposalsController::class, 'store'])->name('proposal.store');
    Route::delete('proposal/{id}', [ProposalsController::class, 'destroy'])->name('proposal.destroy');


    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
