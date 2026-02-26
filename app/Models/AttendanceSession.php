<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
protected $fillable =[
    'timetable_slot_id',
    'date'
];


public function slot()
{
    return $this->belongsTo(TimeTableSlot::class,'timetable_slot_id');
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}
