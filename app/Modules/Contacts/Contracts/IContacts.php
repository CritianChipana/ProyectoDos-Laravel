<?php

    namespace App\Modules\Contacts\Contracts;

    interface IContacts {
        
        public function getContacts();
        public function getContactById($id);
        public function crearContact($data);
        public function deleteContact($id);
        public function updateContact($id,$data);

    }

?>