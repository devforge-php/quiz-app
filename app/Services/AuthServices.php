<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\EmailCodejob;
use App\Jobs\UserListenerJobs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    public function register(RegisterRequest $request): array
    {
        $email = $request->email;
        $userName = $request->user_name;

        if (User::where('user_name', $userName)->exists()) {
            return [
                'data' => ['message' => 'Bu user_name allaqachon mavjud'],
                'status' => 401
            ];
        }

        if (Cache::has("email_sent_$email")) {
            return [
                'data' => ['message' => 'Kodni qayta yuborish uchun 1 daqiqa kuting'],
                'status' => 429
            ];
        }

        $code = rand(100000, 999999);

        Cache::put($code, $request->only('user_name', 'email', 'password'), now()->addMinutes(5));
        Cache::put("email_sent_$email", true, now()->addMinutes(1));

        EmailCodejob::dispatch($code, $email);

        return [
            'data' => ['message' => 'Emailga kod yuborildi'],
            'status' => 200
        ];
    }

    public function verify(Request $request): array
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $userData = Cache::get($request->code);

        if ($userData === null) {
            return [
                'data' => ['message' => 'Kod xato yoki muddati o‘tgan.'],
                'status' => 400
            ];
        }

        if (!isset($userData['user_name'], $userData['email'], $userData['password'])) {
            return [
                'data' => ['message' => 'Cache-dagi ma‘lumotlar to‘liq emas'],
                'status' => 400
            ];
        }

        $user = User::create([
            'user_name' => $userData['user_name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        $token = $user->createToken('Quiz-app')->plainTextToken;
        UserListenerJobs::dispatch($user);

        return [
            'data' => [
                'message' => 'Siz ro‘yxatdan o‘tdingiz',
                'token' => $token,
            ],
            'status' => 201
        ];
    }

    public function login(LoginRequest $request): array
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return [
                'data' => ['message' => 'Email yoki parol xato'],
                'status' => 401
            ];
        }

        $user = Auth::user();
        $token = $user->createToken('Quiz-app')->plainTextToken;

        return [
            'data' => ['token' => $token],
            'status' => 200
        ];
    }

    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();

        return [
            'data' => ['message' => 'Siz tizimdan chiqdingiz'],
            'status' => 200
        ];
    }
}
