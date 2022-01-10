<?php

namespace App\Modules\Authentication\Routes;
// namespace App\Modules\Reports\Controller;

use App\Modules\Authentication\Controllers\AuthenticationController;

use Illuminate\Support\Facades\Route;
 
Route::post("/register",[AuthenticationController::class, "registerUser"]);
Route::post('/login', [AuthenticationController::class,"login"]);
Route::get('/refresh', [AuthenticationController::class,"refresh"]);
Route::get('/user',[AuthenticationController::class,"authenticatedUser"]);

// Route::group(['middleware' => ['jwt.verify']], function() {
// });


?>