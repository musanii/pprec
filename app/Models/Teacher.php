<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable =[
        'user_id',
        'staff_no',
        'phone',
        'gender',
        'is_active',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function assignments()
    {
        return $this->belongsToMany(Subject::class,
        'teacher_subject_class',
        'teacher_id',
        'subject_id'
        )
        ->withPivot('class_id')
        ->withTimestamps();
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
