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
        return $results;
    }
    

    public function getStrategieByUserId(){

        $id = auth()->user()->id;

        $results = $this->IStrategies->getStrategieByUserId($id);
        return $results;
    }

    public function crearStrategie(Request $request){
        $results = $this->IStrategies->crearStrategie($request);
        return $results;
    }

    public function deleteStrategie($id){
        $results = $this->IStrategies->deleteStrategie($id);
        return $results;
    }
    public function updateStrategie($id,Request $request){
        $results = $this->IStrategies->updateStrategie($id, $request);
        return $results;
    }

}


?>