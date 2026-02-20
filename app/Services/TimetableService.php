<?php

namespace App\Services;

use App\Models\TimeTableSlot;
use Illuminate\Validation\ValidationException;

class TimetableService
{
    public function assign(array $data){
        $this->validateTeacherClash($data);
        $this->validateClassClash($data);

        return TimeTableSlot::create($data);
    }


    protected function validateTeacherClash(array $data)
    {
        $exists = TimeTableSlot::where('teacher_id', $data['teacher_id'])
        ->where('term_id', $data['term_id'])
        ->where('day_of_week', $data['day_of_week'])
        ->where('school_period_id', $data['school_period_id'])
        ->exists();

        if($exists){
            throw ValidationException::withMessages([
                'teacher_id'=>'Teacher is already assigned at this time.'
            ]);
        }

    }

    protected function validateClassClash(array $data)
    {
        $exists = TimeTableSlot::where('class_id', $data['class_id'])
        ->where('stream_id', $data['stream_id'])
        ->where('term_id',$data['term_id'])
        ->where('day_of_week', $data['day_of_week'])
        ->where('school_period_id', $data['school_period_id'])
        ->exists();

        if($exists)
            {
                throw ValidationException::withMessages([
                    'school_period_id'=>'Class already has a subject in this period.'
                ]);
            }
    }


}