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

        return Cache::remember($cacheKey, 60, function () use ($categoryId, $difficultyId, $limit) {
            return Question::where('categorie_id', $categoryId)
                ->where('difficultie_id', $difficultyId)
                ->with(['answers:id,question_id,answer_text'])
                ->inRandomOrder()
                ->limit($limit)
                ->get()
                ->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'answers' => $question->answers->map(fn($answer) => [
                            'id' => $answer->id,
                            'answer_text' => $answer->answer_text,
                        ]),
                    ];
                });
        });
    }

    public function checkAnswers($userAnswers)
    {
        $totalScore = 0;

        foreach ($userAnswers as $userAnswer) {
            $isCorrect = Answer::where('question_id', $userAnswer['question_id'])
                ->where('id', $userAnswer['answer_id'])
                ->where('is_correct', true)
                ->exists();

            if ($isCorrect) {
                $totalScore++;
            }
        }

        return $totalScore;
    }
}