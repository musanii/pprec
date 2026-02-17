<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAggregate;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentTranscriptController extends Controller
{
    public function show(Student $student)
    {
        $records = ExamAggregate::with([
        'exam.term.academicYear',
        'exam.term',
        'exam'
    ])
    ->where('student_id', $student->id)
    ->whereHas('exam', fn ($q) => $q->where('is_published', true))
    ->orderByDesc(
        Exam::select('start_date')
            ->whereColumn('exams.id', 'exam_aggregates.exam_id')
    )
    ->get();

        return view('admin.students.transcript', compact('student','records'));
    }
}
