<?php

namespace App\Http\Controllers\Auth;

use App\Events\AuthEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\EmailCodejob;
use App\Jobs\UserListenerJobs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
{
    $email = $request->email;

    if (Cache::has("email_sent_$email")) {
        return response()->json(['message' => 'Kodni qayta yuborish uchun 1 daqiqa kuting'], 429);
    }

    $code = rand(100000, 999999);

    Cache::put($code, $request->only('name', 'email', 'password'), now()->addMinutes(5));
    Cache::put("email_sent_$email", true, now()->addMinutes(1));

    EmailCodejob::dispatch($code, $email);

    return response()->json(['message' => 'Emailga kod yuborildi']);
}

public function verifiy(Request $request)
{
    $request->validate([
        'code' => ['required', 'string'],
    ]);

    $userData = Cache::get($request->code);

    if ($userData === null) {
        return response()->json(['message' => 'Kod xato yoki muddati o\'tgan.'], 400);
    }

    if (!isset($userData['user_name']) || !isset($userData['email']) || !isset($userData['password'])) {
        return response()->json(['message' => 'Cache-dagi ma\'lumotlar to\'liq emas'], 400);
    }

    $user = User::create([
        'user_name' => $userData['user_name'],
        'email' => $userData['email'],
        'password' => Hash::make($userData['password']),
    ]);

    $token = $user->createToken('Quiz-app')->plainTextToken;
    UserListenerJobs::dispatch($user);

    return response()->json([
        'message' => 'Siz  ro\'yxatdan o\'tdingiz',
        'token' => $token,
    ]);
}

public function login(LoginRequest $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Email yoki parol xato'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('Quiz-app')->plainTextToken;

    return response()->json(['token' => $token]);
}

public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Siz tizimdan chiqdingiz']);
}
}
