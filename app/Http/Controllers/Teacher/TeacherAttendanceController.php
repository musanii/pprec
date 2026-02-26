<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Student;
use App\Models\Term;
use App\Models\TimeTableSlot;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
public function index()
{
    $teacher = auth()->user()->teacher;

    $today = strtolower(now()->format('1'));

    $term = Term::where('is_active', true)->first();
    $slots = TimeTableSlot::with(['schoolperiod','subject','schoolClass','stream'])
    ->where('teacher_id', $teacher->id)
    ->where('term_id',$term->id)
    ->where('day_of_week',$today)
    ->orderBy('school_period_id')
    ->get();

    return view('teacher.attendance.index',compact('slots'));
}


public function take(TimeTableSlot $slot)
{
    $today = now()->toDateString();

    $session = AttendanceSession::firstOrCreate([
        'timetable_slot_id' =>$slot->id,
        'date'=>$today
    ]);

    $students = Student::whereHas('enrollments', function($q) use($slot){
        $q->where('class_id', $slot->class_id)
        ->when($slot->stream_id , fn($qq) =>
        $qq->where('stream_id', $slot->stream_id)
        );

    })->with(['user'])->get();

    $existing = $session->attendances()
    ->pluck('status','student_id');

    return view('teacher.attendance.take',compact(
        'slot',
        'session',
        'students',
        'existing'
    ));
}


public function store(Request $request,TimeTableSlot $slot)
{
    $today = now()->toDateString();
    $session = AttendanceSession::firstOrCreate([
        'timetable_slot_id'=>$slot->id,
        'date'=>$today,
    ]);

    foreach($request->statuses as $studentId=>$status)
        {
            Attendance::updateOrCreate(
                [
                    'attendance_session_id'=>$session->id,
                    'student_id'=>$studentId
                ],
                [
                    'status'=>$status
                ]
            );
        }

        return back()->with('success','Attendace saved.');

}
}
