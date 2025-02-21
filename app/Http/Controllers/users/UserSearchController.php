<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Services\LogikServices;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
  public $logikservices;
  public function __construct(LogikServices $logikservices)
  {
    $this->logikservices = $logikservices;
  }
  public function search(Request $request)
  {
        return $this->logikservices->search($request);
  }
}
