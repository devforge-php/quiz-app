<?php 

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserControllerServices
{
    public function index()
    {
        $user = User::all();
         return response()->json(UserResource::collection($user));
    }
    public function show(string $id)
    {
        $user  = User::find($id);
        return response()->json(new UserResource($user));
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete($id);
        return response()->json(['message' => 'ochirildi']);
    }
}


?>