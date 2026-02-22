<?php

namespace App\Services;

use App\Models\TimeTableSlot;
use Illuminate\Validation\ValidationException;

class TimetableService
{
    public function assign(array $data, ?TimeTableSlot $existing=null){
        $this->validateTeacherClash($data, $existing?->id);
        $this->validateClassClash($data, $existing?->id);
        if($existing)
            {
                $existing->update($data);
                return $existing;
            }

        return TimeTableSlot::create($data);
    }


    protected function validateTeacherClash(array $data , $ignoredId=null)
    {
        $query = TimeTableSlot::where('teacher_id', $data['teacher_id'])
        ->where('term_id', $data['term_id'])
        ->where('day_of_week', $data['day_of_week'])
        ->where('school_period_id', $data['school_period_id']);

        if($ignoredId){
            $query->where('id','!=', $ignoredId);
        }
        

        if($query->exists()){
            throw ValidationException::withMessages([
                'teacher_id'=>'Teacher is already assigned at this time.'
            ]);
        }

    }

    protected function validateClassClash(array $data, $ignoredId=null)
    {
        $query = TimeTableSlot::where('class_id', $data['class_id'])
        ->where('stream_id', $data['stream_id'])
        ->where('term_id',$data['term_id'])
        ->where('day_of_week', $data['day_of_week'])
        ->where('school_period_id', $data['school_period_id']);
        if($ignoredId)
            {
                $query->where('id','!=', $ignoredId);
            }
       

        if($query->exists())
            {
                throw ValidationException::withMessages([
                    'school_period_id'=>'Class already has a subject in this period.'
                ]);
            }
    }


}