<?php

    namespace App\Modules\Authentication\Contracts;

    interface IAuthentication {
        
        public function authenticatedUser();
        public function registerUser($data);
        public function login($data);
        public function refresh($data);
        public function deleteUser($id);
        public function updateUser($id,$data);
        public function users();

    }

?>