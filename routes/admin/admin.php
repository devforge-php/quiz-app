<?php

use App\Http\Controllers\admin\Answers\AnswersController;
use App\Http\Controllers\admin\Categorie\CategorieController;
use App\Http\Controllers\admin\Notifactions\UserNotifactionController;
use App\Http\Controllers\admin\Quistons\QuistonsController;
use App\Http\Controllers\admin\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum', 'role:admin'])->group( function () {
           Route::apiResource('category', CategorieController::class);
           Route::apiResource('questions', QuistonsController::class);
           Route::apiResource('answers', AnswersController::class);
           Route::apiResource('notifactions', UserNotifactionController::class);
           Route::apiResource('users', UserController::class);
    });