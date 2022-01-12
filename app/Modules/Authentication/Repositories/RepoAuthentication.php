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
        //todo: validar si el usuario se creo exitosamente
        $report = new Report();
        $report->user_id = $user->id;
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

   


    public function updateUser($id,$data){
        $messages = [
            'firstName.required' => 'El nombre es obligatorio',
            'lastName.required' => 'El apellido es obligatorio',
            'email.required' => 'El email es obligatorio',
            'workSpace.required' => 'El workspace es obligatorio',
            'mobileNo.required' => 'El numero de celular es obligatorio',
            'indutryName.required' => 'El nombre de empresa es obligatorio',
            'position.required' => 'La position del usuario es obligatorio',
            'isActive.required' => 'El estatus del usuario es obligatorio',
            'isAdmi.required' => 'El usuario necesita el campo administrador',
            'isMasterAdmi.required' => 'El usuario necesita el campo master administrador',
           
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
        }

        // try{

            
        //     $result = User::where('id',$id)
        //     ->update([
        //         'firstName'=> $data->firstName,
        //         'lastName'=> $data->lastName,
        //         'email'=> $data->email,
        //         'workSpace'=> $data->workSpace,
        //         'mobileNo'=> $data->mobileNo,
        //         'companyName'=> $data->companyName,
        //         'indutryName'=> $data->indutryName,
        //         'position'=> $data->position,
        //         'isActive'=> $data->isActive,
        //         'isAdmi'=> $data->isAdmi,
        //         'isMasterAdmi'=> $data->isMasterAdmi,
        //     ]);

        //     if( $result ){
        //         return response()->json(
        //             [
        //                 'success' => true, 
        //                 'message' => "El usuario se elimino con exito"
        //             ],200);
        //     }else{
        //         return response()->json(
        //             [
        //                 'success' => false, 
        //                 'message' => "No se encontro usuario"
        //             ],200);
        //     }

        // }catch(Exception $ex){
        //     Log::error('Error API delete User', ['params' => $id, 'stackTrace' => $ex]);
		// 	return response()->json(
		// 		[
		// 			'success' => false, 
		// 			'message' => 'No se encontro Usuario para eliminar'
		// 		],404);
        // }
//? *******************************************
try{
    
    $result = User::find($id);
   

            $result->firstName=$data->firstName;
            $result->lastName=$data->lastName;
            $result->email=$data->email;
            $result->workSpace=$data->workSpace;
            $result->mobileNo=$data->mobileNo;
            $result->companyName=$data->companyName;
            $result->indutryName=$data->indutryName;
            $result->position=$data->position;
            $result->isActive=$data->isActive;
            $result->isAdmi=$data->isAdmi;
            $result->isMasterAdmi=$data->isMasterAdmi;
    
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
                $result->password= Hash::make($data->password);
    
            }
    
            $result->save();

            if( $result ){
                return response()->json(
                    [
                        'success' => true, 
                        'message' => "El usuario se modificar con exito"
                    ],200);
            }else{
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario"
                    ],200);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'data' => $result
            // ], 201);

        }catch(Exception $ex){
            Log::error('Error API update User', ['params' => $id, 'stackTrace' => $ex]);
			return response()->json(
				[
					'success' => false, 
					'message' => 'No se encontro Usuario para modificar'
				],404);
        }

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