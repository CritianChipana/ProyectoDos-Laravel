<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // use HasFactory;
    protected $table = "reports";
    protected $primaryKey = "id";
    protected $fillable = [
        'reportTitle',
        'reportDescription',
        'reportId',
        'groupId',
        'isActive',
        'sectionId',
        'userId',
        'state'
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
