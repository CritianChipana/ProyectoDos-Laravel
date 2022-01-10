<?php

namespace App\Modules\Reports\Controllers;

use App\Modules\Reports\Contracts\IReports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ReportsController extends Controller{
    
    protected $IReports ;

    public function __construct(IReports $IReports){
        $this->IReports = $IReports;
    }

    public function getReports(){
        $results = $this->IReports->getReports();
        return response()->json([
            "success"=>true,
            "data" => $results
        ]);
    }
    
    public function getReportById($id){

        $results = $this->IReports->getReportById($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

    public function crearReport(Request $request){
        $results = $this->IReports->crearReport($request);
        return response()->json([
            "success"=>true,
            "data" => $results, 
        ]);
    }

    public function deleteReport($id){
        $results = $this->IReports->deleteReport($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }
    public function updateReport($id,Request $request){
        $results = $this->IReports->updateReport($id, $request);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

}


?>