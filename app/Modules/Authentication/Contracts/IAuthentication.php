<?php

    namespace App\Modules\Authentication\Contracts;

    interface IAuthentication {
        
        public function userById($user_id);
        public function authenticatedUser();
        public function registerUser($data,$validator);
        public function login($data);
        public function refresh($data);
        public function deleteUser($id);
        public function updateUser($id,$data);
        public function users();

    }

?>