<?php 

namespace App\Services;

use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResourn;
use App\Models\Question;
use Illuminate\Http\Request;


class QuistonsServices 
{
    public function index()
    {
        $questions = Question::all();
        return response()->json(QuestionResourn::collection($questions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $question = Question::create([
            'categorie_id' => $request->categorie_id,
            'difficultie_id' => $request->difficultie_id,
            'question_text' => $request->question_text,
       'created_at' => now(),
'updated_at' => now(),

        ]);
        return response()->json(new QuestionResourn($question));
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return response()->json(new QuestionResourn($question));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());
        return response()->json(new QuestionResourn($question));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['message' => 'Question deleted successfully']);
    }
}



?>