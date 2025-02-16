<?php 
use App\Http\Controllers\users\ChekAnswersController;
use App\Http\Controllers\users\GetQuestionController;
use App\Http\Controllers\users\LevelsController;
use App\Http\Controllers\users\UserSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::middleware(['auth:sanctum', ])->group( function () {
 Route::post('questions', [GetQuestionController::class, 'getQuestion']);
 Route::post('check-answers', [ChekAnswersController::class, 'checkAnswers']);
 Route::get('levels', [LevelsController::class, 'levels']);
 Route::get('search', [UserSearchController::class, 'search']);
});

?>