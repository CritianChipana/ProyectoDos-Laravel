<?php

    namespace App\Modules\Reports\Contracts;

    interface IReports {
        
        public function getReports();
        public function crearReport($data);
        public function getReportById($id);
        public function deleteReport($id);
        public function updateReport($id,$data);

    }

?>