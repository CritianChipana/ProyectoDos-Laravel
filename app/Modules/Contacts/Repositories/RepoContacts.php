<?php

namespace App\Modules\Contacts\Repositories;

use App\Models\Contact;
use App\Modules\Contacts\Contracts\IContacts;

class RepoContacts implements IContacts {

    protected $model ;
    public function __construct($model){
        $this->model = $model;
    }

    public function getContacts(){
        $results = $this->model::table('contacts')
        ->where('state',true)
        ->get();
        return $results;
    }

    public function getContactById($id){
        $results = $this->model::table('contacts')
            // ->select('id','nombre')
            ->where('id',$id)
            ->first();
        return $results;
    }

    public function crearContact($data){
        // $table->id();
        // $table->string("fullName");
        // $table->string("email",100);
        // $table->text("message");
        // $table->boolean("state");
        // $table->timestamps();
        $contact = new Contact();
        $contact->fullName=$data->fullName;
        $contact->email=$data->email;
        $contact->message=$data->message;
        $contact->state=true;
        $contact->save();

        return $contact;

    }

    public function deleteContact($id){

        $contact = Contact::find($id);
        $contact->state=false;
        // $report->delete();
        $contact->save();
        return $contact;

    }

    public function updateContact($id,$data){

        $contact = Contact::find($id);
        $contact->fullName=$data->fullName;
        $contact->email=$data->email;
        $contact->message=$data->message;
        $contact->state=true;
        $contact->save();
        
        return $contact;
    }
    

}


?>