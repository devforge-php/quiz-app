<?php 

namespace App\Services;

use App\Http\Resources\AnswersResource;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswersServices 
{
    /**
     * Barcha javoblarni olish (GET /answers)
     */
    public function index()
    {
        $answers = Answer::all();
        return response()->json(AnswersResource::collection($answers), 200);
    }

    /**
     * Yangi javob yaratish (POST /answers)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
        ]);

        $answer = Answer::create($data);
        return response()->json(new AnswersResource($answer), 201);
    }

    /**
     * Bitta javobni olish (GET /answers/{id})
     */
    public function show($id)
    {
        $answer = Answer::find($id);
        
        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json(new AnswersResource($answer), 200);
    }

    /**
     * Javobni yangilash (PUT /answers/{id})
     */
    public function update(Request $request, $id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        $data = $request->validate([
            'question_id' => 'sometimes|exists:questions,id',
            'answer_text' => 'sometimes|string|max:255',
            'is_correct' => 'sometimes|boolean',
        ]);

        $answer->update($data);
        return response()->json(new AnswersResource($answer), 200);
    }

    /**
     * Javobni o‘chirish (DELETE /answers/{id})
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        $answer->delete();
        return response()->json(['message' => 'Answer deleted successfully'], 200);
    }
}
