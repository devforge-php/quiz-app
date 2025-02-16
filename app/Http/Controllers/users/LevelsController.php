<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileReosurce;
use App\Models\User;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    public function levels()
    {
   
        $topUsers = User::orderBy('score', 'desc') // 'desc' yoki 'asc'
        ->take(10)
        ->get();

return response()->json(ProfileReosurce::collection($topUsers));
    }
}
