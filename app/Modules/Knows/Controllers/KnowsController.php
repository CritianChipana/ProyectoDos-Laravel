<?php

namespace App\Modules\Knows\Controllers;

use App\Modules\Knows\Contracts\IKnows;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class KnowsController extends Controller{
    
    protected $IKnows ;

    public function __construct(IKnows $IKnows){
        $this->IKnows = $IKnows;
    }

    public function getKnows(){
        $results = $this->IKnows->getKnows();
        return response()->json([
            "success"=>true,
            "data" => $results
        ]);
    }
    
    public function getKnowById($id){

        $results = $this->IKnows->getKnowById($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

    public function crearKnow(Request $request){
        $results = $this->IKnows->crearKnow($request);
        return response()->json([
            "success"=>true,
            "data" => $results, 
        ]);
    }

    public function deleteKnow($id){
        $results = $this->IKnows->deleteKnow($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }
    public function updateKnow($id,Request $request){
        $results = $this->IKnows->updateKnow($id, $request);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

}


?>