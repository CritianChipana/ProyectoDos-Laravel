<?php

namespace App\Modules\Authentication\Controllers;

use App\Modules\Authentication\Contracts\IAuthentication;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller{
    
    protected $IAuthentication ;

    public function __construct(IAuthentication $IAuthentication){
        $this->IAuthentication = $IAuthentication;
    }

    public function login(Request $request)
    {
        $result = $this->IAuthentication->login($request);
        return $result;
    }

    public function authenticatedUser()
    {
        $result = $this->IAuthentication->authenticatedUser();
        return $result;
    }


    public function registerUser(Request $request)
    {
        $result = $this->IAuthentication->registerUser($request);
        return $result;
      
    }

    public function refresh(Request $request){
        $result = $this->IAuthentication->refresh($request);
        return $result;
    }


}


?>