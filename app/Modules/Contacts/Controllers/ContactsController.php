<?php

namespace App\Modules\Contacts\Controllers;

use App\Modules\Contacts\Contracts\IContacts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ContactsController extends Controller{
    
    protected $IContacts ;

    public function __construct(IContacts $IContacts){
        $this->IContacts = $IContacts;
    }

    public function getContacts(){
        $results = $this->IContacts->getContacts();
        return response()->json([
            "success"=>true,
            "data" => $results
        ]);
    }
    
    public function getContactById($id){

        $results = $this->IContacts->getContactById($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

    public function crearContact(Request $request){
        $results = $this->IContacts->crearContact($request);
        return response()->json([
            "success"=>true,
            "data" => $results, 
        ]);
    }

    public function deleteContact($id){
        $results = $this->IContacts->deleteContact($id);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }
    public function updateContact($id,Request $request){
        $results = $this->IContacts->updateContact($id, $request);
        return response()->json([
            "success"=>true,
            "data" => $results,
        ]);
    }

}


?>