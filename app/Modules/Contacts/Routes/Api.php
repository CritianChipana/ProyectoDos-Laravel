<?php

namespace App\Modules\Contacts\Routes;

use App\Modules\Contacts\Controllers\ContactsController;

use Illuminate\Support\Facades\Route;
 
Route::get("/contacts",[ContactsController::class, "getContacts"]);
Route::get("/contact/{id}",[ContactsController::class, "getContactById"]);
Route::post("/contact/create",[ContactsController::class, "crearContact"]);
Route::delete("/contact/delete/{id}",[ContactsController::class, "deleteContact"]);
Route::put("/contact/update/{id}",[ContactsController::class, "updateContact"]);

?>