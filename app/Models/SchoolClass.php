<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    protected $fillable =[
        'name',
        'level',
        'is_active'
    ];

      protected $casts = [
        'is_active' => 'boolean',
    ];


    public function streams(){
        return $this->hasMany(Stream::class,'class_id');

    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class,'class_id');
    }
}
