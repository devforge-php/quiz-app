<?php

namespace App\Http\Controllers\admin\Users;

use App\Http\Controllers\Controller;
use App\Services\UserControllerServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public $usercontrollerservices;
  public function __construct(UserControllerServices $usercontrollerservices)
  {
    $this->usercontrollerservices = $usercontrollerservices;
  }
    public function index()
    {
        return $this->usercontrollerservices->index();
    }

 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->usercontrollerservices->show($id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->usercontrollerservices->destroy($id);
    }
}
