<?php

namespace App\Modules\Strategies\Routes;

use App\Modules\Strategies\Controllers\StrategiesController;

use Illuminate\Support\Facades\Route;
 
Route::get("/strategies",[StrategiesController::class, "getStrategies"]);
Route::get("/strategy/{id}",[StrategiesController::class, "getStrategieById"]);
Route::post("/strategy/create",[StrategiesController::class, "crearStrategie"]);
Route::delete("/strategy/delete/{id}",[StrategiesController::class, "deleteStrategie"]);
Route::put("/strategy/update/{id}",[StrategiesController::class, "updateStrategie"]);

?>