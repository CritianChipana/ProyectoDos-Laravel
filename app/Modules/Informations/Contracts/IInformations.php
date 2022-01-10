<?php

    namespace App\Modules\Informations\Contracts;

    interface IInformations {
        
        public function getInformations();
        public function getInformationById($id);
        public function crearInformation($data);
        public function deleteInformation($id);
        public function updateInformation($id,$data);

    }

?>