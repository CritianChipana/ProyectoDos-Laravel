<?php

    namespace App\Modules\Authentication\Contracts;

    interface IAuthentication {
        
        public function authenticatedUser();
        public function registerUser($data,$validator);
        public function login($data);
        public function refresh($data);
        public function deleteUser($id);
        public function updateUser($data);
        public function users();

    }

?>