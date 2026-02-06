<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'stream_id',
        'term_id',
        'is_active',
    ];

     protected $casts = [
        'is_active' => 'boolean',
    ];

     public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(){
        return $this->belongsTo(SchoolClass::class,'class_id');
    }

    public function stream(){
        return $this->belongsTo(Stream::class);

    }

    public function term(){
        return $this->belongsTo(Term::class);
    }
}
