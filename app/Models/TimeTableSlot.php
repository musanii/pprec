<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTableSlot extends Model
{
  protected $fillable =[
    'academic_year_id',
    'term_id',
    'class_id',
    'stream_id',
    'school_period_id',
    'subject_id',
    'teacher_id',
    'day_of_week',
    'is_active'
  ];

  public function AcademicYear()
  {
    return $this->belongsTo(AcademicYear::class);
  }

  public function term()
  {
    return $this->belongsTo(Term::class);
  }

  public function schoolClass()
  {
    return $this->belongsTo(SchoolClass::class, 'class_id');
  }

  public function stream()
  {
    return $this->belongsTo(Stream::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function teacher()
  {
    return $this->belongsTo(Teacher::Class);
  }

  public function schoolPeriod()
  {
    return $this->belongsTo(SchoolPeriod::class);
  }

}
