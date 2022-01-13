<?php

namespace App\Modules\Authentication\Routes;
// namespace App\Modules\Reports\Controller;

use App\Modules\Authentication\Controllers\AuthenticationController;

use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthenticationController::class,"login"]);


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/user',[AuthenticationController::class,"authenticatedUser"]);
    Route::post("/register",[AuthenticationController::class, "registerUser"]);
    Route::get("/me",[AuthenticationController::class, "me"]);
    Route::get('/refresh', [AuthenticationController::class,"refresh"]);
    Route::delete('/deleteUser', [AuthenticationController::class,"deleteUser"]);
    Route::put('/updateUser', [AuthenticationController::class,"updateUser"]);
    Route::get('/users',[AuthenticationController::class,"users"]);
    Route::post('/userById',[AuthenticationController::class,"userById"]);
});

// Route::group(['middleware' => ['web-api','CheckStatusUser']], function () {

    // Route::get('/getReport',                  [SmsController::class, 'getReport'])->middleware(['CheckPermissionsOnUserArray']);
    // Route::get('/getDetailReportSms',        [SmsController::class, 'getDetailReportSms']);
    
    // Route::post('/sendTestSms',               [SmsController::class, 'sendTestSms']);
    // Route::post('/saveSmsFiles',              [SmsController::class, 'saveSmsFiles']);
    // Route::post('/sendSmsCampaingIndividual', [SmsController::class, 'sendSmsCampaingIndividual']);
    // Route::post('/sendSmsCampaingFromExcel',  [SmsController::class, 'sendSmsCampaingFromExcel']);
    // Route::get('/messageCredit',              [SmsController::class, 'messageCredit']);
//   });

?>