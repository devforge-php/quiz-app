<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Services\QuizServices;
use Illuminate\Http\Request;

class ChekAnswersController extends Controller
{
    protected $quizServices;

    public function __construct(QuizServices $quizServices)
    {
        $this->quizServices = $quizServices;
    }

    public function checkAnswers(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        $user = auth()->user();
        $totalScore = $this->quizServices->checkAnswers($validated['answers']);

        // Foydalanuvchi ballarini yangilash
        $user->increment('score', $totalScore);

        return response()->json([
            'total_score' => $totalScore,
            'total_questions' => count($validated['answers']),
            'user_score' => $user->score,
        ]);
    }
}