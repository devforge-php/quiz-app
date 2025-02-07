<?php

use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 




Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update']);
    Route::put('userupdate', [ProfileController::class, 'userupdate']);
    Route::patch('passwordupdate', [ProfileController::class, 'updatepassword']);
    });