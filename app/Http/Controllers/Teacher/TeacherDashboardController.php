<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\Term;
use App\Models\TimeTableSlot;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {

    $teacher = auth()->user()->teacher;
    $today = strtolower(now()->format('1'));
    $term = Term::where('is_active',true)->first();


    //Today's periods
    $todaySlots = TimeTableSlot::with(['subject','schoolClass','stream','schoolPeriod'])
        ->where('teacher_id', $teacher->id)
        ->where('term_id',$term->id)
        ->where('day_of_week',$today)
        ->get();
    
    //Today attendance count
    $todaySessions = AttendanceSession::whereHas('slot', function($q) use ($teacher){
         $q->where('teacher_id', $teacher->id);
    })->whereDate('date',now())->count();

    //Weekly classes
    $weekStart = now()->startOfWeek();
    $weekEnd = now()->endOfWeek();

    $weeklySessions = AttendanceSession::whereHas('slot', function($q) use($teacher){
        $q->where('teacher_id',$teacher->id);
    })->whereBetween('date',[$weekStart,$weekEnd])
    ->count();

        return view('teacher.dashboard', compact(
            'todaySlots',
            'todaySessions',
            'weeklySessions'
        ));
    }
}
