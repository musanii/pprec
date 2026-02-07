<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $fillable=[
        'class_id',
        'name',
        'is_active'
    ];

     protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schoolClass(){
        return $this->belongsTo(SchoolClass::class,'class_id');
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class);

    }
}
