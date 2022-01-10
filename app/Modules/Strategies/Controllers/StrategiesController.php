<?php

namespace App\Modules\Strategies\Controllers;

use App\Modules\Strategies\Contracts\IStrategies;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class StrategiesController extends Controller{
    
    protected $IStrategies ;

    public function __construct(IStrategies $IStrategies){
        $this->IStrategies = $IStrategies;
    }

    public function getStrategies(){
        $results = $this->IStrategies->getStrategies();
        return response()->json([
            "success"=>true,
            "data" => $results
        ]);
    }
    
    public function getStrategieById($id){

        $results = $this->IStrategies->getStrategieById($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

    public function crearStrategie(Request $request){
        $results = $this->IStrategies->crearStrategie($request);
        return response()->json([
            "success"=>true,
            "data" => $results, 
        ]);
    }

    public function deleteStrategie($id){
        $results = $this->IStrategies->deleteStrategie($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }
    public function updateStrategie($id,Request $request){
        $results = $this->IStrategies->updateStrategie($id, $request);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

}


?>