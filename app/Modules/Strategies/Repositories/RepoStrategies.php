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

    public function getStrategieByUserId($userId){

        $results = $this->model::table('strategies')
            ->where('userId', $userId)
            ->where('state',true)
            ->orderBy('id', 'desc')
            ->first();

        return [
            "success"=>true,
            "data" => $results,
        ];
    }

    public function crearStrategie($data){
        // $table->string("strategy",80);

        // $table->unsignedBigInteger('userId')->nullable();
        // $table->foreign('userId')->references('id')->on('users')->onDelete('set null');
        // $table->boolean("state");

        /*
        $strategy = new Strategy();
        $url = Storage::put('/public', $data->file('file'));
        $strategy->strategy=Storage::url($url);
        $strategy->user_id=$data->userId;
        $strategy->state=true;
        $strategy->save();
        */

        $id = Strategy::insertGetId([
            "userId" => $data->userId,
            "strategy" => $data->strategy,
            "state" => true
        ]);

        if ($id > 0) {
            $response = [
                "success" => true,
                "message" => "Se guardó la Estratégia con éxito"
            ];
        } else {
            $response = [
                "success" => true,
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