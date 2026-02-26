<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Stream;
use App\Models\Student;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
public function index(Request $request)
{
    $classId = $request->class_id;
    $streamId = $request->stream_id;
    $from = $request->from;
    $to = $request->to; 
    $classes = SchoolClass::orderBy('level')->get();
     $streams = collect();
        if($classId)
            {
                $streams = Stream::where('class_id',$classId)->orderBy('name')->get();
            }

            $query = Attendance::query()
            ->with(['student.user'])
            ->when($from, fn($q) => $q->whereDate('created_at','>=',$from))
            ->when($to, fn($q) => $q->whereDate('created_at','<=',$to))
            ->when($classId,  function($q) use($classId){
                $q->whereHas('student.enrollments',fn($qq)=> $qq->where('class_id',$classId)
                );

            })->when($streamId, function($q) use ($streamId){
                $q->whereHas('student.enrollments', fn($qq)=>
                $qq->where('stream_id', $streamId));
            });

            $summary = (clone $query)
            ->selectRaw("
            COUNT(*) as total,
            SUM(status='present') as present,
            SUM(status='absent') as absent,
            SUM(status='late') as late,
            SUM(status='excused') as excused

            ")
            ->first();

            $percentage = $summary->total > 0 
            ? round(($summary->present / $summary->total) * 100, 2)
            :0;


        return view('admin.attendance.index',compact('classes','streams','summary','classId','percentage','streamId','from','to'));
}


public function students(Request $request)
{
    $classId  = $request->class_id;
    $streamId = $request->stream_id;

    $classes = SchoolClass::orderBy('level')->get();
     $streams = collect();
        if($classId)
            {
                $streams = Stream::where('class_id',$classId)->orderBy('name')->get();
            }
    $students = Student::with(['user'])
        ->withCount([
            'attendances as present_count' => fn($q)=>$q->where('status','present'),
            'attendances as total_count'
        ])
        ->when($classId, function($q) use ($classId){
            $q->whereHas('enrollments', fn($qq)=>
                $qq->where('class_id',$classId)
            );
        })
        ->when($streamId, function($q) use ($streamId){
            $q->whereHas('enrollments', fn($qq)=>
                $qq->where('stream_id',$streamId)
            );
        })
        ->paginate(25);

    return view('admin.attendance.students', compact(
        'students','classes','streams',
        'classId','streamId'
    ));
}


public function analytics()
{
    $monthly = Attendance::selectRaw("
        DATE_FORMAT(created_at,'%Y-%m') as month,
        SUM(status='present') as present,
        COUNT(*) as total
    ")
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $months = $monthly->pluck('month');
    $rates = $monthly->map(function($row){
        return $row->total > 0
            ? round(($row->present/$row->total)*100,2)
            : 0;
    });

    return view('admin.attendance.analytics', compact(
        'months','rates'
    ));
}
}
