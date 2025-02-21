<?php

namespace App\Services;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuistonsServices
{
    public function index()
    {
        return Question::all();
    }

    public function store(QuestionRequest $request)
    {
        return Question::create($request->all());
    }

    public function show(Question $question)
    {
        return $question;
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->all());
        return $question;
    }

    public function destroy(Question $question)
    {
        $question->delete();
    }
}
