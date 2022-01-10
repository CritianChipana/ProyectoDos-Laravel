<?php

namespace App\Modules\Strategies\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Modules\Strategies\Contracts\IStrategies;
use App\Modules\Strategies\Repositories\RepoStrategies;
use Illuminate\Support\Facades\DB as FacadesDB;

class ServiceOrchestration extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IStrategies::class, function (){
            return new RepoStrategies(new FacadesDB);
        });
    }
}

?>