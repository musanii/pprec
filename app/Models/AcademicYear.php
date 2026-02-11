<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable =[
        'name',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function terms(){
        return $this->hasMany(Term::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function scopeActive($query){
        return $query->where('is_active', true);
    }
}
