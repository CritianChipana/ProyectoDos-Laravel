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
use PhpParser\Node\Stmt\TryCatch;

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

    public function deleteUser($userId){

        try{
            
            $result = User::where('id',$userId)
            ->update([
                'state'=>false
            ]);

            if( $result ){
                return response()->json(
                    [
                        'success' => true, 
                        'message' => "El usuario se elimino con exito"
                    ],200);
            }else{
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario"
                    ],200);
            }

        }catch(Exception $ex){
            Log::error('Error API delete User', ['params' => $userId, 'stackTrace' => $ex]);
			return response()->json(
				[
					'success' => false, 
					'message' => 'No se encontro Usuario para eliminar'
				],404);
        }
  
    }

   


    public function updateUser($data){
        $messages = [
            'firstName.required' => 'El nombre es obligatorio',
            'lastName.required' => 'El apellido es obligatorio',
            'email.required' => 'El email es obligatorio',
            'workSpace.required' => 'El workspace es obligatorio',
            'mobileNo.required' => 'El numero de celular es obligatorio',
            'indutryName.required' => 'El nombre de empresa es obligatorio',
            'position.required' => 'El position de empresa es obligatorio',
            'isActive.required' => 'El isActive de empresa es obligatorio',
            'isAdmi.required' => 'El isAdmi de empresa es obligatorio',
            'isMasterAdmi.required' => 'El isMasterAdmi de empresa es obligatorio',
           
        ];
        
        // $validator=Validator::make($request->all(), [
        //     'celular_sms' => 'required|numeric|regex:/^(?:9)/',
        //     'mensaje_sms' => 'required',
        // ],$messages
        // );

        // if ($validator->fails()) {
        //     return response()->json(array(
        //         'success' => false,
        //         'ecelular_sms' => $validator->errors()->first('celular_sms'),
        //         'emensaje_sms' => $validator->errors()->first('mensaje_sms'),
        //         ), 200);
        // }

        $validator = Validator::make($data->all(), [
            'id' => 'required',
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
        ],$messages);
        if($validator->fails()){

			return response()->json(
				[
					'success' => false, 
					'message' => $validator->errors()
				],400);
            // return response()->json($validator->errors()->toJson(),400);
        }


        $user = User::find($data->id);
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

        if($data->password){

            $validator = Validator::make($data->all(), [
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                return response()->json(
                    [
                        'success' => false, 
                        'message' => $validator->errors()
                    ],400);
            }
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