<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Cache;

class QuizServices
{
   
    public function getQuestions($categoryId, $difficultyId, $limit)
    {
      
        $cacheKey = "questions_{$categoryId}_{$difficultyId}_{$limit}";

        // Keshda mavjud bo'lsa, keshdan o'qiydi
        return Cache::remember($cacheKey, 60, function () use ($categoryId, $difficultyId, $limit) {
            $questions = Question::where('categorie_id', $categoryId)
                ->where('difficultie_id', $difficultyId)
                ->with(['answers' => function ($query) {
                    $query->select('id', 'question_id', 'answer_text');
                }])
                ->inRandomOrder()
                ->limit($limit)
                ->get();

            // Formatchlangan savollar
            return $questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'answers' => $question->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'answer_text' => $answer->answer_text,
                        ];
                    }),
                ];
            });
        });
    }

    
    public function checkAnswers($userAnswers)
    {
        $totalScore = 0;

        foreach ($userAnswers as $userAnswer) {
            $correctAnswer = Answer::where('question_id', $userAnswer['question_id'])
                ->where('is_correct', true)
                ->first();

            if ($correctAnswer && $correctAnswer->id === $userAnswer['answer_id']) {
                $totalScore += 1; // To'g'ri javob uchun 1 ball
            }
        }

        return $totalScore;
    }
}