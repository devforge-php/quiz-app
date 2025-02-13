<?php

namespace App\Http\Controllers\admin\Answers;

use App\Http\Controllers\Controller;
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
        return $this->answersService->index();
    }

    public function store(Request $request)
    {
        return $this->answersService->store($request);
    }

    public function show($id)
    {
        return $this->answersService->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->answersService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->answersService->destroy($id);
    }
}
