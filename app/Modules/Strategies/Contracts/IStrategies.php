<?php

    namespace App\Modules\Strategies\Contracts;

    interface IStrategies {
        
        public function getStrategies();
        public function getStrategieByUserId($id);
        public function crearStrategie($data);
        public function deleteStrategie($id);
        public function updateStrategie($id,$data);

    }

?>