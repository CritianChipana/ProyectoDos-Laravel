<?php

namespace App\Modules\Informations\Routes;

use App\Modules\Informations\Controllers\InformationsController;

use Illuminate\Support\Facades\Route;
 
Route::get("/informations",[InformationsController::class, "getInformations"]);
Route::get("/information/{id}",[InformationsController::class, "getInformationById"]);
Route::post("/information/create",[InformationsController::class, "crearInformation"]);
Route::delete("/information/delete/{id}",[InformationsController::class, "deleteInformation"]);
Route::put("/information/update/{id}",[InformationsController::class, "updateInformation"]);

?>