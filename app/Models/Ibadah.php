<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    protected $table = "ibadah";

    protected $fillable = [
        'user_id',
        'date',
        'kategori',
        'prayer_name',
        'target_count', 
        'target_unit',  
        'time',         
        'notes',        
        'status',
        'frequency',
    ];
}
