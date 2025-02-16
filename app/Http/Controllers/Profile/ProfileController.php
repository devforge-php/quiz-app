<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdate;
use App\Http\Resources\ProfileReosurce;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return response()->json(new ProfileReosurce($user));
    }
    public function update(Request $request)
    {
    $profile = Auth::user()->profile;

    if (!$profile) {
        return response()->json(['error' => 'Profil topilmadi'], 404);
    }
       
         if ($request->hasFile('image')) {
  
            $image = $request->file('image');
            $imagePath = $image->store('profiles', 'public'); 
            $profile->image = $imagePath; 
        }

        $profile->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
        ]);
         
        return redirect()->route('profile')->with(['message' => 'ozgartirildi']);

    }

    public function userupdate(Request $request)
    {
     $user = Auth::user();
     $user->name = $request->input('name');
     $user->email = $request->input('email');

     $user->save();

     return response()->json(new ProfileReosurce($user));
    }

    public function updatepassword(Request $request)
    {
  $user = Auth::user();

  if (!Hash::check($request->old_password, $user->password)) {
    return response()->json(['message' => 'Eski parol noto\'g\'ri.'], 400);
}
 
   $validator = Validator::make($request->all(), [
     'new_password' => ['required', 'string', 'max:8', ],
   ]);
       

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message' => 'Parol muvaffaqiyatli yangilandi']);

    }

}
