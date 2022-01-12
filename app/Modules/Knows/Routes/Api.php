<?php

namespace App\Modules\Knows\Routes;

use App\Modules\Knows\Controllers\KnowsController;

use Illuminate\Support\Facades\Route;
 
Route::get("/knows",[KnowsController::class, "getKnows"]);
Route::get("/know/{id}",[KnowsController::class, "getKnowById"]);
Route::post("/know/create",[KnowsController::class, "crearKnow"]);
Route::delete("/know/delete",[KnowsController::class, "deleteKnow"]);
Route::post("/know/update",[KnowsController::class, "updateKnow"]);

?>