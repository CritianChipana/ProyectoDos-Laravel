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
        $validator = Validator::make($request->all(), [
            
            'firstName' => 'required',
            'lastName' => 'required',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:100|unique:users',
            'workSpace' => '',
            'mobileNo' => '',
            'companyName' => '',
            'indutryName' => '',
            'position' => '',
            'isActive' => 'required|boolean',
            'isAdmi' => 'required|boolean',
            'isMasterAdmi' => 'required|boolean',
            'state' => 'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $result = $this->IAuthentication->registerUser($request, $validator);
        return $result;
      
    }

    public function refresh(Request $request){
        $result = $this->IAuthentication->refresh($request);
        return $result;
    }

    public function deleteUser(Request $request){
        $userId = $request->userId;
        $result = $this->IAuthentication->deleteUser($userId);
        return $result;
    }
    public function updateUser(Request $request){
        $id = $request->id;
        $result = $this->IAuthentication->updateUser($id,$request);
        return $result;
    }
    public function users(){
        $result = $this->IAuthentication->users();
        return $result;
    }

}


?>