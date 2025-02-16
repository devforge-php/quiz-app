<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetQuestionRequest;
use App\Services\QuizServices;
use Illuminate\Http\Request;

class GetQuestionController extends Controller
{
    protected $quizServices;

    public function __construct(QuizServices $quizServices)
    {
        $this->quizServices = $quizServices;
    }

    public function getQuestion(GetQuestionRequest $request)
    {
        $validated = $request->validated();

        $questions = $this->quizServices->getQuestions(
            $validated['categorie_id'],
            $validated['difficultie_id'],
            $validated['limit']
        );

        return response()->json($questions);
    }
}