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
            return response()->json(['message' => 'Kodni qayta yuborish uchun 1-daqiqa kuting kuting'], 429);
        }
    
        $code = rand(100000, 999999);
    
        Cache::put($code, $request->only('name', 'email', 'password'), now()->addMinutes(5));
        Cache::put("email_sent_$email", true, now()->addSeconds(1));
    
        EmailCodejob::dispatch($code, $email);
    
        return response()->json(['message' => 'Emailga kod yuborildi']);
    }
    

    public function verifiy(Request $reqesut)
    {
        $reqesut->validate([
            'code' => ['required', 'string'],
        ]);
    
        $userData = Cache::get($reqesut->code);
    
        if ($userData === null) {
            return response()->json([
                'message' => 'Kod xato yoki muddati o\'tgan.',
            ], 400);
        }
    
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        UserListenerJobs::dispatch($user);
        return response()->json([
            'message' => 'Siz Chanlydan royhatdan otdingiz',
        ]);
    }
    public function login(LoginRequest $reqesut)
    {
        if(!Auth::attempt($reqesut->only('email', 'password')))
        {
            return response()->json(['message' => 'Email Yoki Password xatolik bor'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('Quiz-app')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {

        $request->user()->tokens->each( function ($token) {
          $token->delete();
        });
        return response()->json(['message' => 'Siz Tizimdan Chiqdiz']);

    }
}
