<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileReosurce;
use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
  public function search(Request $request)
  {
    // Qidiruv so'rovini olish
    $query = $request->input('user_name');

    // Userlar jadvalidan qidiruvni amalga oshirish
    $users = User::where('user_name', 'LIKE', '%' . $query . '%')
                 ->with('profile') // Profile bilan bog'langan ma'lumotlarni yuklash
                 ->get();

    // Natijani qaytarish
    return response()->json(ProfileReosurce::collection($users));    
  }
}
