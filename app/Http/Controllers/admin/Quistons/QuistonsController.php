<?php

namespace App\Http\Controllers\admin\Quistons;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Services\QuistonsServices;
use Illuminate\Http\Request;

class QuistonsController extends Controller
{
public $questionservices;
public function __construct(QuistonsServices $questionservices)
{
    $this->questionservices = $questionservices;
}
    public function index()
    {
        return $this->questionservices->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        return $this->questionservices->store($request);   
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return $this->questionservices->show($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request,Question $question)
    {
        return $this->questionservices->update($request, $question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        return $this->questionservices->destroy($question);
    }
}
