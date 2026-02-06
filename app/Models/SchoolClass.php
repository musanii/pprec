<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';
    protected $fillable =[
        'name',
        'level'
    ];

    public function streams(){
        return $this->hasMany(Stream::class,'class_id');

    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class,'class_id');
    }
}
