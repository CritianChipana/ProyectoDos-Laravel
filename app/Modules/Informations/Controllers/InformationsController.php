<?php

namespace App\Modules\Informations\Controllers;

use App\Modules\Informations\Contracts\IInformations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class InformationsController extends Controller{
    
    protected $IInformations ;

    public function __construct(IInformations $IInformations){
        $this->IInformations = $IInformations;
    }

    public function getInformations(){
        $results = $this->IInformations->getInformations();
        return response()->json([
            "success"=>true,
            "data" => $results
        ]);
    }
    
    public function getInformationById($id){

        $results = $this->IInformations->getInformationById($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

    public function crearInformation(Request $request){
        $results = $this->IInformations->crearInformation($request);
        return response()->json([
            "success"=>true,
            "data" => $results, 
        ]);
    }

    public function deleteInformation($id){
        $results = $this->IInformations->deleteInformation($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }
    public function updateInformation($id,Request $request){
        $results = $this->IInformations->updateInformation($id, $request);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

}


?>