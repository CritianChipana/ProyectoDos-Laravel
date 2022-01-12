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
        return $results;
    }
    
    public function getKnowById(Request $request){
        $userId=$request->userId;
        $results = $this->IKnows->getKnowById($userId);
        return $results;
    }

    public function crearKnow(Request $request){
        $results = $this->IKnows->crearKnow($request);
        return $results;
    }

    public function deleteKnow(Request $request){
        $id= $request->id;
        $results = $this->IKnows->deleteKnow($id);
        return $results;
    }
    public function updateKnow(Request $request){
        $id= $request->id;
        $results = $this->IKnows->updateKnow($id, $request);
        return $results;
   
    }

}


?>