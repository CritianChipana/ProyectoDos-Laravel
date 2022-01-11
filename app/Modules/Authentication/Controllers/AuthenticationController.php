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

    public function me ()
	{
		return response()->json(
			[
				'success' => true
			], 200
		);
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

    public function deleteUser($id){
        $result = $this->IAuthentication->deleteUser($id);
        return $result;
    }
    public function updateUser($id,Request $request){
        $result = $this->IAuthentication->updateUser($id,$request);
        return $result;
    }
    public function users(){
        $result = $this->IAuthentication->users();
        return $result;
    }

}


?>