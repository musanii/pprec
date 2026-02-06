<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable =[
        'academic_year_id',
        'name',
        'start_date',
        'end_date',
        'is_active',

    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }

    public function scopeActive($query){
        return $query->where('is_active', true);
    }
}
