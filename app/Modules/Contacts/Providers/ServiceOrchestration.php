<?php

namespace App\Modules\Contacts\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Modules\Contacts\Contracts\IContacts;
use App\Modules\Contacts\Repositories\RepoContacts;
use Illuminate\Support\Facades\DB as FacadesDB;

class ServiceOrchestration extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IContacts::class, function (){
            return new RepoContacts(new FacadesDB);
        });
    }
}

?>