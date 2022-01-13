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
        return $results;
    }
    
    public function getReportById(Request $request){
        $userId = $request->userId;
        $results = $this->IReports->getReportById($userId);
        return $results;

    }

    public function crearReport(Request $request){
        $results = $this->IReports->crearReport($request);
        return $results;

    }

    public function deleteReport(Request $request){
        $id=$request->userId;
        $results = $this->IReports->deleteReport($id);
        return $results;

    }
    public function updateReport(Request $request){
        $id = $request->userId;
        $results = $this->IReports->updateReport($id, $request);
        return $results;

    }
    public function embed(Request $request){
        $results = $this->IReports->embed($request);
        return $results;

    }
}


?>