<?php

namespace App\Modules\Reports\Repositories;

use App\Models\Cliente;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use App\Modules\Reports\Contracts\IReports;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

        try{
            $report =  Report::where('userId', $userId)->first();
            
            return [
                "success" => true,
                "data" => $report
            ];

        } catch (Exception $ex) {
            Log::error('Error API get repostbyId', ['params' => $userId, 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se encontro el report, hable con el admi'
                ],
                404
            );
            
        }

            
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

    public function updateReport($id, $data){

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
            /*
            $user = User::where('state',true)->find($data->userId);
            if( !$user ){
                
                return response()->json(
                    [
                        'success' => false, 
                        'message' => "No se encontro usuario con el userId"
                    ],400);
            }*/

            $result = Report::where('userId', $id)
                ->update([
                    'summaryDashBoard' => $data->summaryDashBoard,
                    'billing' => $data->billing,
                    'billing'=> $data->billing,
                    'presale'=> $data->presale,
                    'rawMaterial'=> $data->rawMaterial,
                    'humanResources'=> $data->humanResources,
                    'oee'=> $data->oee,
                    'firecCost'=> $data->firecCost,
                    'adminWorkSheet'=> $data->adminWorkSheet,
                    'maintenance'=> $data->maintenance,
                    'ouBoundLogistics'=> $data->ouBoundLogistics,
                    'marketing'=> $data->marketing,
                    'rentals'=> $data->rentals,
                    'services'=> $data->services,
                    'userId'=> $data->userId,
                ]);
            
            /*
            $result = Report::where('state',true)->where("userId", $id);

           

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
            $result->userId=$data->userId;
            $result->state=$data->state;
            $result->save();
            */


            if ($result) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "El reporte se modificar con exito"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => "No se encontro el reporte"
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
    
    public function embed($data){

        $access_token = $this->access_token();
        $token = $this->token_view($data);


        try {

            $result = Http::withHeaders([
                'Authorization' => 'Bearer '.$access_token,
                'Content-Type' => 'application/json'
                ])->get('https://api.powerbi.com/v1.0/myorg/groups/'.auth()->user()->workSpace.'/reports/'.$data->reportId, [
    
                'language' => 'json',
                ]);
            $embedUrl = $result->json()['embedUrl'];
            $id = $result->json()['id'];
    
            return response()->json(
                [
                    'success' => true,
                    'token' => $token,
                    'embeUrl' => $embedUrl,
                    'id' =>$id 
                ],
                200
            );
        
        } catch (ConnectionException $ex) {
            Log::error('Error API embed ', ['params' => 'https://api.powerbi.com/v1.0/myorg/groups/'.auth()->user()->workSpace.'/reports/'.$data->reportId , 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'error embed, hable con el admi',
                    'error'=>$ex
                ],
                500
            );
        }

      

    }

    protected function access_token(){

        try {

            $result = Http::asForm()->post('https://login.microsoftonline.com/65e8aa94-e441-49b1-9502-08318650e0c4/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_secret' => 'dlH7Q~d.YV7IROcRSotaJ3Up7A2XQB_likREb',
                'client_id' => 'd3b91711-815b-42a9-a6a9-b15033b97a89',
                'resource' => 'https://analysis.windows.net/powerbi/api',
            ]);
    
            return $result->json()['access_token'];
        
        } catch (ConnectionException $ex) {
            Log::error('Error API acces_token ', ['params' => 'https://login.microsoftonline.com/65e8aa94-e441-49b1-9502-08318650e0c4/oauth2/token' , 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se pudo generar el access token, hable con el admi',
                    'error'=>$ex
                ],
                500
            );
        }

    }

    protected function token_view($data){

        try {
            $access_token = $this->access_token();

            $result = Http::withHeaders([
                // 'Authorization' => 'Bearer '.'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCIsImtpZCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCJ9.eyJhdWQiOiJodHRwczovL2FuYWx5c2lzLndpbmRvd3MubmV0L3Bvd2VyYmkvYXBpIiwiaXNzIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvNjVlOGFhOTQtZTQ0MS00OWIxLTk1MDItMDgzMTg2NTBlMGM0LyIsImlhdCI6MTY0MjA0MDAwNSwibmJmIjoxNjQyMDQwMDA1LCJleHAiOjE2NDIwNDM5MDUsImFpbyI6IkUyWmdZRERid1hWanp3WkRreDNuWXJoV3JzaDBCQUE9IiwiYXBwaWQiOiJkM2I5MTcxMS04MTViLTQyYTktYTZhOS1iMTUwMzNiOTdhODkiLCJhcHBpZGFjciI6IjEiLCJpZHAiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC82NWU4YWE5NC1lNDQxLTQ5YjEtOTUwMi0wODMxODY1MGUwYzQvIiwib2lkIjoiMmI2ZjU1ZDktZDNjZi00MDkzLThiNzMtODUxNTczNGE5NjE4IiwicmgiOiIwLkFYY0FsS3JvWlVIa3NVbVZBZ2d4aGxEZ3hCRVh1ZE5iZ2FsQ3BxbXhVRE81ZW9sM0FBQS4iLCJzdWIiOiIyYjZmNTVkOS1kM2NmLTQwOTMtOGI3My04NTE1NzM0YTk2MTgiLCJ0aWQiOiI2NWU4YWE5NC1lNDQxLTQ5YjEtOTUwMi0wODMxODY1MGUwYzQiLCJ1dGkiOiJGa2d6WnpIQ1ZVQ2Y3aGNsc29SUEFRIiwidmVyIjoiMS4wIn0.htA9lbBoOtHGA5DXuW1dlEcGMd4dk6PzK1VYrPxdDw4feGecmRMqeK3V2fHOxs4W2P2P22YldgNoYLzB6IppJ4S2Ne4KN9Pyig7HVFwWL3hm9ZddOPmtuky25ctIDgAChMJdeMUaIDs34acX367AUfczry6AMvAWKTGSdVzX-bluFcrTxP_QoRSWZ70NYfVQMRW1vHADQBt4i_uAIlqWxtwL7lsUqPH0Kjscd-6woFbjfwuMonTd7hI5RMUpC2_t92lPX0tyNzX2jUBg7CpTTV-cHClFBkDTsLtKYEhA56RSsNL87WPCu1h6EFtkOcwaDl3YcZV0E0RRUpRw9ygW2w',
                'Authorization' => 'Bearer '.$access_token,
                'Content-Type' => 'application/json'
            // ])->post('https://api.powerbi.com/v1.0/myorg/groups/9bef4d95-8eb5-4b8e-b7cc-157c0a944443/reports/885234cf-ed53-4ac9-a2bc-2d621272e37d/GenerateToken', [
            ])->post('https://api.powerbi.com/v1.0/myorg/groups/'.auth()->user()->workSpace.'/reports/'.$data->reportId.'/GenerateToken', [
                'accessLevel' => 'View',
            ]);

            return $result->json()['token'];

        } catch (\Throwable $ex) {
            Log::error('Error API token_view ', ['params' => 'https://api.powerbi.com/v1.0/myorg/groups/'.auth()->user()->workSpace.'/reports/'.$data->reportId.'/GenerateToken' , 'stackTrace' => $ex]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No se pudo generar el token view, hable con el admi',
                    'error'=>$ex
                ],
                500
            );
        }
    }

}



?>