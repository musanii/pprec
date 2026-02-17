<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAggregate extends Model
{
    protected $fillable = [
        'exam_id', 
        'student_id',
         'stream_id', 
         'total_marks',
         'mean_score', 
         'class_rank',
          'stream_rank',
          'result_hash'
    ];

public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    
 }
