<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentExamResultController extends Controller
{
    public function show(Student $student, Exam $exam){
        $results = ExamResult::with('subject')
            ->where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->orderBy('subject_id')
            ->get();

        $total = $results->sum('marks');
        $average = $results->count()
            ? round($results->avg('marks'), 2)
            : null;

        return view('admin.students.exam-results', compact(
            'student',
            'exam',
            'results',
            'total',
            'average'
        ));


    }
}
