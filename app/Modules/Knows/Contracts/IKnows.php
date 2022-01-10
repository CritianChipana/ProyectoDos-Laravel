<?php

    namespace App\Modules\Knows\Contracts;

    interface IKnows {
        
        public function getKnows();
        public function getKnowById($id);
        public function crearKnow($data);
        public function deleteKnow($id);
        public function updateKnow($id,$data);

    }

?>