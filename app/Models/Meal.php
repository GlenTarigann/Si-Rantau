<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meal';

    protected $fillable = [
        'user_id',
        'planned_date',
        'meal_time',
        'recipe_name',
        'recipe_api_id',
        'notes'
    ];
}
