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
    ];
}
