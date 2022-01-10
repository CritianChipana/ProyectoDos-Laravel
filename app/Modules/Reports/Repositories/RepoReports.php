<?php

namespace App\Modules\Reports\Repositories;

use App\Models\Cliente;
use App\Models\Product;
use App\Models\Report;
use App\Modules\Reports\Contracts\IReports;

class RepoReports implements IReports {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function getReports(){
        $results = $this->model::table('reports')->get();
        return $results;
    }

    public function getReportById($id){
        $results = $this->model::table('reports')
            ->select('id','nombre')
            ->where('id',$id)
            ->first();
        return $results;
    }

    public function crearReport($data){

        $report = new Report();
        $report->nombre=$data->nombre;
        $report->save();

        return $report;

    }

    public function deleteReport($id){

        $report = Report::find($id);
        $report->delete();
        return $report;

    }

    public function updateReport($id,$data){

        $report = Report::find($id);
        $report->nombre=$data->nombre;
        $report->save();
        return $report;

    }
    

}


?>