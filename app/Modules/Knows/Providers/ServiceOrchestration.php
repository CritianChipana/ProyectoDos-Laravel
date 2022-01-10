<?php

namespace App\Modules\Knows\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Modules\Knows\Contracts\IKnows;
use App\Modules\Knows\Repositories\RepoKnows;
use Illuminate\Support\Facades\DB as FacadesDB;

class ServiceOrchestration extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IKnows::class, function (){
            return new RepoKnows(new FacadesDB);
        });
    }
}

?>