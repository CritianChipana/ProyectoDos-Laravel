<?php

namespace App\Modules\Knows\Repositories;

use App\Models\Know;
use App\Models\User;
use App\Modules\Knows\Contracts\IKnows;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RepoKnows implements IKnows
{

    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getKnows()
    {
        $results = $this->model::table('knows')
            ->where('state', true)
            ->get();
        return $results;
    }

    public function getKnowById($id)
    {
        if(!$id){

            return response()->json(
                [
                    'success' => false,
                    'message' => "No se encontro userId"
                ],
                401
            );
        }

        try{
            
                $user = User::where('state', true)->find($id);
                $result = $user->knows->where('state', true);

            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'data' => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro know"
                    ],
                    200
                );
            }
            

        } catch (Exception $ex) {
            Log::error('Error API get know', ['params' => $id, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se creo el conocimiento, hable con el admi'
                ],
                404
            );
            
        }


       
    }

    public function crearKnow($data)
    {
        //      $table->string("knowName",50);
        //     $table->string("knowArea",50);
        //     $table->string("typeOfFile",7);
        //     $table->string("knowArchive",7);
        //     $table->unsignedBigInteger('userId')->nullable();
        //     $table->boolean("state");

        $messages = [
            'knowName.required' => 'El nombre es obligatorio',
            'knowArea.required' => 'El area es obligatorio',
            'typeOfFile.required' => 'El tipo del archivo es obligatorio',
            'knowArchive.required' => 'El archivo es obligatorio',
            'userId.required' => 'El usuario es obligatorio (id)',
        ];

        $validator = Validator::make($data->all(), [
            'knowName' => 'required',
            'knowArea' => 'required',
            'typeOfFile' => 'required',
            'knowArchive' => 'required',
            'userId' => 'required',

        ], $messages);
        
        if ($validator->fails()) {
            
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }
        
        try{

            $user = User::find($data->userId);

            if( !$user ){
                
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario con el userId"
                    ],400);
            }
                
            $result = new Know();
            $result->knowName = $data->knowName;
            $result->knowArea = $data->knowArea;
            $result->typeOfFile = $data->typeOfFile;
            $url = Storage::put('/public/know', $data->file('knowArchive'));
            $result->knowArchive = Storage::url($url);
            $result->userId = $data->userId;
            $result->save();
    
            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El conocimiento se creo con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se creo know"
                    ],
                    400
                );
            }

            
        } catch (Exception $ex) {
            Log::error('Error API crear know', ['params' => $data, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se creo el conocimiento, hable con el admi'
                ],
                404
            );
            
        }

        
    }

    public function deleteKnow($id)
    {


        try {

            $result = Know::where('id', $id)->Where('state',true)
                ->update([
                    'state' => false
                ]);

            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El conocimiento se elimino con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro know"
                    ],
                    400
                );
            }
        } catch (Exception $ex) {
            Log::error('Error API delete know', ['params' => $id, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se encontro know para eliminar'
                ],
                404
            );
        }
    }

    public function updateKnow($id, $data)
    {

        // {
        //     "id":2,
        //     "knowName":"caminar",
        //     "knowArea":"area nose manito",
        //     "typeOfFile":"word",
        //     "knowArchive":"asasd",
        //     "userId":1
        // }

        $messages = [
            'id.required' => 'El id del conocimiento es obligatorio',
            'knowName.required' => 'El nombre es obligatorio',
            'knowArea.required' => 'El area es obligatorio',
            'typeOfFile.required' => 'El tipo del archivo es obligatorio',
            'knowArchive.required' => 'El archivo es obligatorio',
            'userId.required' => 'El usuario es obligatorio (id)',

        ];

        $validator = Validator::make($data->all(), [
            'id' => 'required',
            'knowName' => 'required',
            'knowArea' => 'required',
            'typeOfFile' => 'required',
            'knowArchive' => 'required',
            'userId' => 'required',

        ], $messages);

        if ($validator->fails()) {

            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        try {

            $user = User::where('state',true)->find($data->userId);
            if( !$user ){
                
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario con el userId"
                    ],400);
            }

            $result = Know::where('state',true)->find($id);
            $result->knowName = $data->knowName;
            $result->knowArea = $data->knowArea;
            $result->typeOfFile = $data->typeOfFile;
            $url = Storage::put('/public/know', $data->file('knowArchive'));
            $result->knowArchive = Storage::url($url);
            $result->userId = $data->userId;
            $result->save();

            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El conocimiento se modificar con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro conocimiento"
                    ],
                    200
                );
            }
        } catch (Exception $ex) {
            Log::error('Error API  update know', ['params' => $id ,'data'=>$data, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se encontro conocimiento para modificar, hable con el admi'
                ],
                404
            );
        }
    }
}
