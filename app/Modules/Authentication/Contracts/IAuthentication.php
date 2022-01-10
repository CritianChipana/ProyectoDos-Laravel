<?php

    namespace App\Modules\Authentication\Contracts;

    interface IAuthentication {
        
        public function authenticatedUser();
        public function registerUser($data);
        public function login($data);
        public function refresh($data);

    }

?>