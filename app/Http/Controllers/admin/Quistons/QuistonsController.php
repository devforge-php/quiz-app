<?php

namespace App\Http\Controllers\Admin\Quistons;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResourn;
use App\Models\Question;
use App\Services\QuistonsServices;
use Illuminate\Http\Request;

class QuistonsController extends Controller
{
    protected $questionservices;

    public function __construct(QuistonsServices $questionservices)
    {
        $this->questionservices = $questionservices;
    }

    public function index()
    {
        $questions = $this->questionservices->index();
        return response()->json(QuestionResourn::collection($questions));
    }

    public function store(QuestionRequest $request)
    {
        $question = $this->questionservices->store($request);
        return response()->json(new QuestionResourn($question), 201);
    }

    public function show(Question $question)
    {
        $question = $this->questionservices->show($question);
        return response()->json(new QuestionResourn($question));
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question = $this->questionservices->update($request, $question);
        return response()->json(new QuestionResourn($question));
    }

    public function destroy(Question $question)
    {
        $this->questionservices->destroy($question);
        return response()->json(['message' => 'Question deleted successfully'], 200);
    }
}
