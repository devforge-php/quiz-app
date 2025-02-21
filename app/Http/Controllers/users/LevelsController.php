<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileReosurce;
use App\Models\User;
use App\Services\LogikServices;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    public $logikservices;
    public function __construct(LogikServices $logikservices)
    {
      $this->logikservices = $logikservices;
    }
    public function levels()
    {
     return $this->logikservices->levels();
    }
}
