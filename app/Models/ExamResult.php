<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'exam_id',
        'student_id',
        'subject_id',
        'class_id',
        'marks',
        'grade',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
