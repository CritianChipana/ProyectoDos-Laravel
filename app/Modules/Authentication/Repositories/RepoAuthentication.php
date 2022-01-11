<?php

namespace App\Modules\Authentication\Repositories;

use App\Models\Report;
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

    public function me ()
	{
		return response()->json(
			[
				'success' => true, 
				'expires_in' => auth()->factory()->getTTL() * 60,
				'data' => auth()->user()
			], 200
		);
	}

    public function registerUser($data, $validator){

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => Hash::make($data->password)]
            // ['password' => bcrypt($data->password)]
        ));
        // $hash = Hash::make('secret');
        $report = new Report();
        $report->userId = $user->id;
        $report->state = true;
        $report->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ], 201);
    }
    
    public function login($data){

        //todo: validar que el usuario tenga estado true
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $report = $this->model::table('reports')
            ->where('userId',auth()->id())
            ->first();
        
        return response()->json([
            'success' => true, 
            'data' => [
                'access_token' => $token,
                'user'=>auth()->user(),
                'report'=>$report
            ]
        ]);

        // return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'data'=>auth()->user()
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

    public function deleteUser($id){
        $user = User::find($id);
        $user->state=false;
        // $report->delete();
        $user->save();
        return $user;
    }

    public function updateUser($id,$data){
        $validator = Validator::make($data->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            // 'password' => 'required|string|min:6',
            'email' => 'required',
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

        // $user = User::updated(array_merge(
        //     $validator->validate(),
        //     ['password' => bcrypt($data->password)]
        // ));


        $user = User::find($id);
        $user->firstName=$data->firstName;
        $user->lastName=$data->lastName;
        $user->email=$data->email;
        $user->workSpace=$data->workSpace;
        $user->mobileNo=$data->mobileNo;
        $user->companyName=$data->companyName;
        $user->indutryName=$data->indutryName;
        $user->position=$data->position;
        $user->isActive=$data->isActive;
        $user->isAdmi=$data->isAdmi;
        $user->isMasterAdmi=$data->isMasterAdmi;
        $user->state=$data->state;
        // todo validar si el password del usuario es el mismo que el de la BD
        if($data->password){
            $user->password= Hash::make($data->password);

        }

        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ], 201);
    }

    public function users(){
        $results = $this->model::table('users')
        ->where('state',true)
        ->get();
    
        return [
            'success' => true,
            'data' => $results
        ];
    }

}


?>