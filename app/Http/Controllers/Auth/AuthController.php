<?php

namespace App\Http\Controllers\Auth;

use App\Events\AuthEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\EmailCodejob;
use App\Jobs\UserListenerJobs;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $AuthServices;
    public function __construct(AuthServices $AuthServices)
    {
        $this->AuthServices = $AuthServices;
    }
    public function register(RegisterRequest $request)
    {
     return $this->AuthServices->register($request);
    }
    

public function verifiy(Request $request)
{
    
    return $this->AuthServices->verifiy($request);
  }

public function login(LoginRequest $request)
{
    return $this->AuthServices->login($request);
}

public function logout(Request $request)
{
    return $this->AuthServices->logout($request);
}
}
