<?php

namespace App\Modules\Authentication\Repositories;

use App\Modules\Authentication\Contracts\IAuthentication;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class RepoAuthentication implements IAuthentication {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function authenticatedUser(){
        // try {
        //     if (!$user = JWTAuth::parseToken()->authenticate()) {
        //     // if (!$user = auth()->parseToken()->authenticate()) {
        //             return response()->json(['user_not_found'], 404);
        //     }
        //   } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        //           return response()->json(['token_expired'], $e->getStatusCode());
        //   } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        //           return response()->json(['token_invalid'], $e->getStatusCode());
        //   } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        //           return response()->json(['token_absent'], $e->getStatusCode());
        //   }
        //   return response()->json(compact('user'));
        return response()->json(auth()->user());
    }

    public function registerUser($data){
        $validator = Validator::make($data->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($data->password)]
        ));

        return response()->json([
            'message' => '¡Usuario registrado exitosamente!',
            'user' => $user
        ], 201);
    }
    
    
    public function login($data){
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function refresh($request){
        try {
			$token = auth()->refresh();
			return response()->json(
				[
					'success' => true, 
					'data' => 
						[
							'token' => $token,
							'token_type' => 'bearer', 
							'expires_in' => auth()->factory()->getTTL() * 60
						]
				], 200
			);
		} catch (Exception $ex) {
			Log::error('Error API refrest()', ['params' => $request, 'stackTrace' => $ex]);
			return response()->json(
				[
					'success' => false, 
					'message' => 'Ocurrió un error al refrescar sesión'
				]);
		}
    }

}


?>