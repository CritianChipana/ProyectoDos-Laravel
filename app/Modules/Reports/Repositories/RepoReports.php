<?php

namespace App\Modules\Reports\Repositories;

use App\Models\Cliente;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use App\Modules\Reports\Contracts\IReports;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function getReportById($userId){
        $results = $this->model::table('reports')
            // ->select('id','nombre')
            ->where('id',$userId)
            ->first();
            return response()->json(
                [
                    'success' => true, 
                    'data' => $results
                ],200);
    }

    public function crearReport($data){

    
        try{

            $user = User::find($data->userId);

            if( !$user ){
                
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario con el userId"
                    ],400);
            }
                
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
    
            if ($report) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El reporte se creo con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se creo reporte"
                    ],
                    400
                );
            }

            
        } catch (Exception $ex) {
            Log::error('Error API crear report', ['params' => $data, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se creo el report, hable con el admi'
                ],
                500
            );
            
        }


    }

    public function deleteReport($id){

        try {

            $result = Report::where('id', $id)->Where('state',true)
                ->update([
                    'state' => false
                ]);

            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El reporte se elimino con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro reporte"
                    ],
                    400
                );
            }
        } catch (Exception $ex) {
            Log::error('Error API delete report', ['params' => $id, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se encontro reporte para eliminar'
                ],
                404
            );
        }



    }

    public function updateReport($id,$data){

        $messages = [
            'userId.required' => 'El usuario es obligatorio (id)',
        ];

        $validator = Validator::make($data->all(), [

            'userId' => 'required',

        ], $messages);
        
        if ($validator->fails()) {
            
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        try {

            $user = User::where('state',true)->find($data->userId);
            if( !$user ){
                
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario con el userId"
                    ],400);
            }

            $result = Report::where('state',true)->find($id);
            $result->billing=$data->billing;
            $result->presale=$data->presale;
            $result->rawMaterial=$data->rawMaterial;
            $result->humanResources=$data->humanResources;
            $result->oee=$data->oee;
            $result->firecCost=$data->firecCost;
            $result->adminWorkSheet=$data->adminWorkSheet;
            $result->maintenance=$data->maintenance;
            $result->ouBoundLogistics=$data->ouBoundLogistics;
            $result->marketing=$data->marketing;
            $result->rentals=$data->rentals;
            $result->services=$data->services;
            $result->user_id=$data->userId;
            $result->state=$data->state;
            $result->save();

            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El conocimiento se modificar con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro conocimiento"
                    ],
                    200
                );
            }
        } catch (Exception $ex) {
            Log::error('Error API  update report', ['params' => $id ,'data'=>$data, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se encontro reporte para modificar, hable con el admi'
                ],
                404
            );
        }

    }
    

}


?>