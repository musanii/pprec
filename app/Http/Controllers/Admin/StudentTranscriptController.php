<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentTranscriptController extends Controller
{
    public function show(Student $student)
    {
        $records = $student->examAggregates()
        ->with('exam.term','exam.academicYear')
        ->orderByDesc('created_at')
        ->get();

        return view('admin.students.transcript', compact('student','records'));
    }
}
