<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\Student;
use App\Models\Term;
use App\Models\TimeTableSlot;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {

    $teacher = auth()->user()->teacher;
   
    $term = Term::where('is_active',true)->first();
     $todayName = strtolower(now()->format('l'));
     $todayDate = now()->toDateString();

     


    //Today's periods
    $todaySlots = TimeTableSlot::with(['subject','schoolClass','stream','schoolPeriod'])
        ->where('teacher_id', $teacher->id)
        ->where('term_id',$term->id)
        ->where('day_of_week',$todayName)
        ->orderBy('school_period_id')
        ->get();
    
    //Today attendance count
    $todaySessions = AttendanceSession::whereHas('slot', function($q) use ($teacher){
         $q->where('teacher_id', $teacher->id);
    })->whereDate('date',$todayDate)
    ->pluck('timetable_slot_id')
    ->toArray();

    $completedToday = count($todaySessions);
    $pendingToday = $todaySlots->count() - $completedToday;
    

    //Week load
    $weekSlots = TimeTableSlot::where('teacher_id',$teacher->id)
    ->where('term_id', $term->id)
    ->count();
    
    //unique classes taught
    $uniqueClasses = TimeTableSlot::where('teacher_id',$teacher->id)
     ->distinct('class_id')
     ->count('class_id');

     //unique student exposure
     $studentsCount = Student::whereHas('enrollments', function($q) use($teacher){
        $q->whereIn('class_id', TimeTableSlot::where('teacher_id', $teacher->id)
        ->pluck('class_id'));
     })->count();

        return view('teacher.dashboard', compact(
            'todaySlots',
            'completedToday',
            'pendingToday',
            'weekSlots',
            'uniqueClasses',
            'studentsCount',
            'todaySessions'
        ));
    }
}
