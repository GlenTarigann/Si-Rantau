<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'user_id', 
        'task_name', 
        'task_category', 
        'deadline', 
        'progres_status', 
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    protected $casts = [
        'deadline' => 'datetime', 
    ];
}