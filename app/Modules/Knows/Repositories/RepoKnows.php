<?php

namespace App\Modules\Knows\Repositories;

use App\Models\Know;
use App\Modules\Knows\Contracts\IKnows;

class RepoKnows implements IKnows {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function getKnows(){
        $results = $this->model::table('knows')
        ->where('state',true)
        ->get();
        return $results;
    }

    public function getKnowById($id){
        $results = $this->model::table('knows')
            // ->select('id','nombre')
            ->where('id',$id)
            ->where('state',true)
            ->first();
        return $results;
    }

    public function crearKnow($data){
        //      $table->string("knowName",50);
        //     $table->string("knowArea",50);
        //     $table->string("typeOfFile",7);
        //     $table->string("knowArchive",7);
        //     $table->unsignedBigInteger('userId')->nullable();
        //     $table->boolean("state");
        $know = new Know();
        $know->knowName=$data->knowName;
        $know->knowArea=$data->knowArea;
        $know->typeOfFile=$data->typeOfFile;
        $know->knowArchive=$data->knowArchive;
        $know->userId=$data->userId;
        $know->state=true;
        $know->save();

        return $know;

    }

    public function deleteKnow($id){

        $know = Know::find($id);
        $know->state=false;
        // $report->delete();
        $know->save();
        return $know;

    }

    public function updateKnow($id,$data){

        $know = Know::find($id);
        $know->knowName=$data->knowName;
        $know->knowArea=$data->knowArea;
        $know->typeOfFile=$data->typeOfFile;
        $know->knowArchive=$data->knowArchive;
        $know->userId=$data->userId;
        $know->state=$data->state;
        $know->save();
        
        return $know;
    }
    

}


?>