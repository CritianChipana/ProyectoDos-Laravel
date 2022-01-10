<?php

namespace App\Modules\Informations\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Modules\Informations\Contracts\IInformations;
use App\Modules\Informations\Repositories\RepoInformations;
use Illuminate\Support\Facades\DB as FacadesDB;

class ServiceOrchestration extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IInformations::class, function (){
            return new RepoInformations(new FacadesDB);
        });
    }
}

?>