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
        $results = $this->model::table('reports')
        ->where('state',true)
        ->get();
        return $results;
    }

    public function getReportById($id){
        $results = $this->model::table('reports')
            // ->select('id','nombre')
            ->where('id',$id)
            ->first();
        return $results;
    }

    public function crearReport($data){

        $report = new Report();
        $report->billing=$data->billing;
        $report->presale=$data->presale;
        $report->rawMaterial=$data->rawMaterial;
        $report->humanResources=$data->humanResources;
        $report->oee=$data->oee;
        $report->firecCost=$data->firecCost;
        $report->adminWorkSheet=$data->adminWorkSheet;
        $report->maintenance=$data->maintenance;
        $report->ouBoundLogistics=$data->ouBoundLogistics;
        $report->marketing=$data->marketing;
        $report->rentals=$data->rentals;
        $report->services=$data->services;
        $report->user_id=$data->userId;
        $report->state=true;
        $report->save();

        return $report;

    }

    public function deleteReport($id){

        $report = Report::find($id);
        $report->state=false;
        // $report->delete();
        $report->save();
        return $report;

    }

    public function updateReport($id,$data){

        $report = Report::find($id);
        $report->billing=$data->billing;
        $report->presale=$data->presale;
        $report->rawMaterial=$data->rawMaterial;
        $report->humanResources=$data->humanResources;
        $report->oee=$data->oee;
        $report->firecCost=$data->firecCost;
        $report->adminWorkSheet=$data->adminWorkSheet;
        $report->maintenance=$data->maintenance;
        $report->ouBoundLogistics=$data->ouBoundLogistics;
        $report->marketing=$data->marketing;
        $report->rentals=$data->rentals;
        $report->services=$data->services;
        $report->user_id=$data->userId;
        $report->state=$data->state;
        $report->save();
        return $report;

    }
    

}


?>