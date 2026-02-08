<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionLog extends Model
{
    protected $fillable = [
        'academic_year_id',
        'user_id',
        'action',
        'total_students',
        'promoted',
        'graduated',
        'repeated',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }  
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
