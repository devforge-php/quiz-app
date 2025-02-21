<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckAnswersRequest;
use App\Services\QuizServices;
use Illuminate\Http\Request;

class ChekAnswersController extends Controller
{
    protected $quizServices;

    public function __construct(QuizServices $quizServices)
    {
        $this->quizServices = $quizServices;
    }

    public function checkAnswers(CheckAnswersRequest $request)
    {
        // Validatsiya
        $validated = $request->all();

        $user = auth()->user();

        // Ballarni hisoblash
        $totalScore = $this->quizServices->checkAnswers($validated['answers']);
        $user->increment('score', $totalScore);

        // Feedback ma'lumotlari
        $totalQuestions = count($validated['answers']);
        $correctAnswers = $totalScore;
        $incorrectAnswers = $totalQuestions - $correctAnswers;

        return response()->json([
            'total_score' => $totalScore,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'incorrect_answers' => $incorrectAnswers,
            'user_score' => $user->score,
            'motivational_message' => $this->generateMotivationalMessage($correctAnswers, $totalQuestions),
        ]);
    }

    private function generateMotivationalMessage($correctAnswers, $totalQuestions)
    {
        $percentage = ($correctAnswers / $totalQuestions) * 100;

        if ($percentage >= 90) {
            return "Ajoyib! Sizning natijangiz juda yuqori. Davom eting!";
        } elseif ($percentage >= 70) {
            return "Yaxshi ish qildingiz! Ammo biroz ko'proq mashq qilsangiz hammasini yaxshi o'rganishingiz mumkin.";
        } elseif ($percentage >= 50) {
            return "Yaxshi boshlangan ish! Lekin sizga yana bir necha urinish kerak bo'ladi. Urinib ko'ring!";
        } else {
            return "Sizning natijangiz kamroq, lekin bu hech narsani anglatmaydi. Yana urinib ko'ring va o'zingizni sinab ko'ring!";
        }
    }
}