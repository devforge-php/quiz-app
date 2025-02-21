<?php

namespace App\Services;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswersServices
{
    public function index()
    {
        return Answer::all();
    }

    public function store(AnswerRequest $request)
    {
        $data = $request->all();
        return Answer::create($data);
    }

    public function show($id)
    {
        return Answer::find($id);
    }

    public function update(AnswerRequest $request, $id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return null;
        }

        $data = $request->validate([
            'question_id' => 'sometimes|exists:questions,id',
            'answer_text' => 'sometimes|string|max:255',
            'is_correct' => 'sometimes|boolean',
        ]);

        $answer->update($data);
        return $answer;
    }

    public function destroy($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return false;
        }

        $answer->delete();
        return true;
    }
}
