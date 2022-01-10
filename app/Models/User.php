<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',
        'firstName',
        'lastName',
        'password',
        'email',
        'workSpace',
        'mobileNo',
        'companyName',
        'indutryName',
        'position',
        'isActive',
        'isAdmi',
        'isMasterAdmi',
        'state',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function getJWTIdentifier()
    {
    	return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
    	return [];
    }

      //relacion de uno a muchos
    public function reports(){
        return $this->hasMany('App\Models\Report');
    }
    public function contacts(){
        return $this->hasMany('App\Models\Contact');
    }
    public function knows(){
        return $this->hasMany('App\Models\Know');
    }
    public function informations(){
        return $this->hasMany('App\Models\Information');
    }
    public function strategies(){
        return $this->hasMany('App\Models\Strategy');
    }
}
