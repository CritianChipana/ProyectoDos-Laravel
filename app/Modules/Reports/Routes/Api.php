<?php

namespace App\Modules\Reports\Routes;

use App\Modules\Reports\Controllers\ReportsController;

use Illuminate\Support\Facades\Route;
 
Route::get("/reports",[ReportsController::class, "getReports"]);
Route::get("/report/buscarReport/{id}",[ReportsController::class, "getReportById"]);
Route::post("/report/register",[ReportsController::class, "register"]);
Route::post("report/create",[ReportsController::class, "crearReport"]);
Route::delete("report/delete/{id}",[ReportsController::class, "deleteReport"]);
Route::put("/report/update/{id}",[ReportsController::class, "updateReport"]);

?>