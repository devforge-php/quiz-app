<?php

namespace App\Http\Controllers\Admin\Answers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswersResource;
use App\Services\AnswersServices;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    protected $answersService;

    public function __construct(AnswersServices $answersService)
    {
        $this->answersService = $answersService;
    }

    public function index()
    {
        $answers = $this->answersService->index();
        return response()->json(AnswersResource::collection($answers), 200);
    }

    public function store(AnswerRequest $request)
    {
        $answer = $this->answersService->store($request);
        return response()->json(new AnswersResource($answer), 201);
    }

    public function show($id)
    {
        $answer = $this->answersService->show($id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json(new AnswersResource($answer), 200);
    }

    public function update(AnswerRequest $request, $id)
    {
        $answer = $this->answersService->update($request, $id);

        if (!$answer) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json(new AnswersResource($answer), 200);
    }

    public function destroy($id)
    {
        $deleted = $this->answersService->destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'Answer not found'], 404);
        }

        return response()->json(['message' => 'Answer deleted successfully'], 200);
    }
}
