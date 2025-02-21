<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdate;
use App\Http\Resources\ProfileReosurce;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileServices $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json(new ProfileReosurce($user));
    }

    public function update(Request $request)
    {
        $this->profileService->updateProfile($request);
        return redirect()->route('profile')->with(['message' => 'O\'zgartirildi']);
    }

    public function userUpdate(Request $request)
    {
        $this->profileService->updateUser($request);
        return response()->json(['message' => 'Foydalanuvchi yangilandi']);
    }

    public function updatePassword(Request $request)
    {
        $this->profileService->changePassword($request);
        return response()->json(['message' => 'Parol muvaffaqiyatli yangilandi']);
    }
}
