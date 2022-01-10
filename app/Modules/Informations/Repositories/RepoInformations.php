<?php

namespace App\Modules\Informations\Repositories;

use App\Models\Information;
use App\Models\Know;
use App\Modules\Informations\Contracts\IInformations;

class RepoInformations implements IInformations {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function getInformations(){
        $results = $this->model::table('information')
        ->where('state',true)
        ->get();
        return $results;
    }

    public function getInformationById($id){
        $results = $this->model::table('information')
            // ->select('id','nombre')
            ->where('id',$id)
            ->where('state',true)
            ->first();
        return $results;
    }

    public function crearInformation($data){
        
        // $table->string("billing",80);
        // $table->string("presale",80);
        // $table->string("rawMaterial",80);
        // $table->string("humanResources",80);
        // $table->string("oee",80);
        // $table->string("firecCost",80);
        // $table->string("adminWorkSheet",80);
        // $table->string("maintenance",80);
        // $table->string("ouBoundLogistics",80);
        // $table->string("marketing",80);
        // $table->string("rentals",80);
        // $table->string("services",80);

        // $table->unsignedBigInteger('userId')->nullable();

        $information = new Information();
        $information->billing=$data->billing;
        $information->presale=$data->presale;
        $information->rawMaterial=$data->rawMaterial;
        $information->humanResources=$data->humanResources;
        $information->oee=$data->oee;
        $information->firecCost=$data->firecCost;
        $information->adminWorkSheet=$data->adminWorkSheet;
        $information->maintenance=$data->maintenance;
        $information->ouBoundLogistics=$data->ouBoundLogistics;
        $information->marketing=$data->marketing;
        $information->rentals=$data->rentals;
        $information->services=$data->services;
        $information->userId=$data->userId;
        $information->state=true;
        $information->save();

        return $information;

    }

    public function deleteInformation($id){

        $information = Information::find($id);
        $information->state=false;
        // $report->delete();
        $information->save();
        return $information;

    }

    public function updateInformation($id,$data){

        $information = Information::find($id);
        $information->billing=$data->billing;
        $information->presale=$data->presale;
        $information->rawMaterial=$data->rawMaterial;
        $information->humanResources=$data->humanResources;
        $information->oee=$data->oee;
        $information->firecCost=$data->firecCost;
        $information->adminWorkSheet=$data->adminWorkSheet;
        $information->maintenance=$data->maintenance;
        $information->ouBoundLogistics=$data->ouBoundLogistics;
        $information->marketing=$data->marketing;
        $information->rentals=$data->rentals;
        $information->services=$data->services;
        $information->userId=$data->userId;
        $information->state=$data->state;
        $information->save();

        
        return $information;
    }
    

}


?>