<?php

namespace App\Modules\Strategies\Repositories;

use App\Models\Know;
use App\Models\Strategy;
use App\Modules\Strategies\Contracts\IStrategies;
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

    public function getStrategieById($id){
        $results = $this->model::table('strategies')
            // ->select('id','nombre')
            ->where('id',$id)
            ->where('state',true)
            ->first();
        return $results;
    }

    public function crearStrategie($data){
        // $table->string("strategy",80);

        // $table->unsignedBigInteger('userId')->nullable();
        // $table->foreign('userId')->references('id')->on('users')->onDelete('set null');
        // $table->boolean("state");

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
        $strategy = new Strategy();
        $url = Storage::put('/public', $data->file('file'));
        $strategy->strategy=Storage::url($url);
        $strategy->user_id=$data->userId;
        $strategy->state=true;

        $strategy->save();
        return $strategy;
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