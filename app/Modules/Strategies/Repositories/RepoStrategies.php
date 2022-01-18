<?php

namespace App\Modules\Strategies\Repositories;

use App\Models\Know;
use App\Models\Strategy;
use App\Modules\Strategies\Contracts\IStrategies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RepoStrategies implements IStrategies {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function getStrategies(){
        $results = $this->model::table('strategies')
        ->where('state',true)
        ->get();
        return $results;
    }

    public function getStrategieByUserId($id){
        $id = auth()->user()->id;
        $results = $this->model::table('strategies')
            ->where('userId', $id)
            ->where('state',true)
            ->orderBy('id', 'desc')
            ->first();

            if ($results) {
               return response()->json(
                [
                    'success' => true,
                    'message' => $results
                ],
                200);
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "no se encontro estrategias del usuario"
                    ],
                    200);
            }

    }

    public function crearStrategie($data){

        $messages = [
            'file.required' => 'La estrategia es obligatorio',
            'userId.required' => 'El userId es obligatorio',
        ];

        $validator = Validator::make($data->all(), [

            'file' => 'required',
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

        $strategy = new Strategy();
        $url = Storage::put('/public/strategy', $data->file('file'));
        $strategy->strategy=Storage::url($url);
        $strategy->userId=$data->userId;
        $strategy->state=true;
        $strategy->save();
       

        // $id = Strategy::insertGetId([
        //     "userId" => $data->userId,
        //     "strategy" => $data->strategy,
        //     "state" => true
        // ]);

        if ($strategy) {
            $response = [
                "success" => true,
                "message" => "Se guardó la Estratégia con éxito"
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "No se pude guardar la estatégia"
            ];
        }

        return $response;
    }

    public function deleteStrategie($id){

        $strategy = Strategy::find($id);
        $strategy->state=false;
        // $report->delete();
        $strategy->save();
        return $strategy;

    }

    public function updateStrategie($id,$data){

        $strategy = Strategy::find($id);
        $strategy->strategy=$data->strategy;
        $strategy->user_id=$data->userId;
        $strategy->state=$data->state;
        $strategy->save();
        
        return $strategy;
    }
    

}


?>