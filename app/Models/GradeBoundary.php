<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeBoundary extends Model
{
    protected $fillable =[
        'grade',
        'min_score',
        'max_score',
        'points',
        'is_active'

    ];
}
