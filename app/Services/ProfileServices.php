<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileServices
{
    public function updateProfile(Request $request)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            throw new \Exception('Profil topilmadi');
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
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthorized');
        }

        $request->validate([
            'user_name' => 'required|string|max:255|unique:users,user_name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            throw new \Exception('Eski parol noto\'g\'ri.');
        }

        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    }
}
