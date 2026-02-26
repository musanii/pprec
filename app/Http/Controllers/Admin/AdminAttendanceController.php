<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
public function index(Request $request)
{
    $classId = $request->class_id;
    $classes = SchoolClass::orderBy('level')->get();

    $report = null;

    if($classId)
        {
            $report = Attendance::whereHas('students.enrollments', function($q) use($classId){
                $q->where('class_id',$classId);
            })
            ->selectRaw("
            status,
            COUNT(*) as total
            ")
            ->groupBy('status')
            ->pluck('total','status');

        }
        return view('admin.attendance.index',compact('classes','report','classId'));
}
}
