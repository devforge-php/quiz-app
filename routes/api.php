<?php

use App\Http\Controllers\admin\Answers\AnswersController;
use App\Http\Controllers\admin\Categorie\CategorieController;
use App\Http\Controllers\admin\Notifactions\UserNotifactionController;
use App\Http\Controllers\admin\Quistons\QuistonsController;
use App\Http\Controllers\admin\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\users\ChekAnswersController;
use App\Http\Controllers\users\GetQuestionController;
use App\Http\Controllers\users\LevelsController;
use App\Http\Controllers\users\UserSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// auth start

Route::post('register', [AuthController::class, 'register']);
Route::post('verifiy', [AuthController::class, 'verifiy']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);
         
    });

    // auth end



// admin start

Route::middleware(['auth:sanctum', 'role:admin'])->group( function () {
    Route::apiResource('category', CategorieController::class);
    Route::apiResource('question', QuistonsController::class);
    Route::apiResource('answer', AnswersController::class);
    Route::apiResource('notifactions', UserNotifactionController::class);
    Route::apiResource('users', UserController::class);
});


// admin end


// user start
Route::middleware(['auth:sanctum', ])->group( function () {
    Route::post('questions', [GetQuestionController::class, 'getQuestion']);
    Route::post('check-answers', [ChekAnswersController::class, 'checkAnswers']);
    Route::get('levels', [LevelsController::class, 'levels']);
    Route::get('search', [UserSearchController::class, 'search']);
   });
// user end


// profile start

Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update']);
    Route::put('userupdate', [ProfileController::class, 'userupdate']);
    Route::patch('passwordupdate', [ProfileController::class, 'updatepassword']);
    });


    // profile end