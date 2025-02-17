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
        // Validatsiya qilamiz
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        $user = auth()->user();

        // QuizServices orqali ballarni hisoblaymiz
        $totalScore = $this->quizServices->checkAnswers($validated['answers']);

        // Foydalanuvchi ballarini yangilash
        $user->increment('score', $totalScore);

        // Feedback yaratish uchun kerakli ma'lumotlarni tayyorlaymiz
        $totalQuestions = count($validated['answers']);
        $correctAnswers = $totalScore; // To'g'ri javoblar soni
        $incorrectAnswers = $totalQuestions - $correctAnswers; // Noto'g'ri javoblar soni

        // Motivatsion feedback yaratamiz
        $motivationalMessage = $this->generateMotivationalMessage($correctAnswers, $totalQuestions);

        return response()->json([
            'total_score' => $totalScore,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'incorrect_answers' => $incorrectAnswers,
            'user_score' => $user->score,
            'motivational_message' => $motivationalMessage, // Motivatsion xabar
        ]);
    }

    private function generateMotivationalMessage($correctAnswers, $totalQuestions)
    {
        // To'g'ri javoblar foizi
        $correctPercentage = ($correctAnswers / $totalQuestions) * 100;

        if ($correctPercentage >= 90) {
            return "Ajoyib! Sizning natijangiz juda yuqori. Davom eting!";
        } elseif ($correctPercentage >= 70) {
            return "Yaxshi ish qildingiz! Ammo biroz ko'proq mashq qilsangiz hammasini yaxshi o'rganishingiz mumkin.";
        } elseif ($correctPercentage >= 50) {
            return "Yaxshi boshlangan ish! Lekin sizga yana bir necha urinish kerak bo'ladi. Urinib ko'ring!";
        } else {
            return "Sizning natijangiz kamroq, lekin bu hech narsani anglatmaydi. Yana urinib ko'ring va o'zingizni sinab ko'ring!";
        }
    }
}