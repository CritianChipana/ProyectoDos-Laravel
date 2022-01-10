<?php

namespace App\Modules\Reports\Routes;

use App\Modules\Reports\Controllers\ReportsController;

use Illuminate\Support\Facades\Route;
 
Route::get("/reports",[ReportsController::class, "getReports"]);
Route::post("/register",[ReportsController::class, "register"]);
Route::post("/create",[ReportsController::class, "crearReport"]);
Route::get("/buscarReport/{id}",[ReportsController::class, "getReportById"]);
Route::delete("/eliminar/{id}",[ReportsController::class, "deleteReport"]);
Route::put("/modificar/{id}",[ReportsController::class, "updateReport"]);

?>