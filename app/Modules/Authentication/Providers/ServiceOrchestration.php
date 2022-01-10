<?php

namespace App\Modules\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Modules\Authentication\Contracts\IAuthentication;
use App\Modules\Authentication\Repositories\RepoAuthentication;
use Illuminate\Support\Facades\DB as FacadesDB;

class ServiceOrchestration extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IAuthentication::class, function (){
            return new RepoAuthentication(new FacadesDB);
        });
    }
}

?>