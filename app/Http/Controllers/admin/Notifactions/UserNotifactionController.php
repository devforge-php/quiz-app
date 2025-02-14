<?php

namespace App\Http\Controllers\admin\Notifactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserNotifactionResource;
use App\Models\Notifaction;
use Illuminate\Http\Request;

class UserNotifactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Notifaction::paginate(10);
        return response()->json(UserNotifactionResource::collection($user));
    }

 

   
    public function show(string $id)
    {
        $user  = Notifaction::find($id);
        return response()->json(new UserNotifactionResource($user));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user  = Notifaction::find($id);

        $user->delete();
        return response()->json(['message' => 'Delete ']);
    }
}
