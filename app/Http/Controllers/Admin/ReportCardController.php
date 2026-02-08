<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportCardController extends Controller
{
    public function show(Student $student, Exam $exam)
    {
        $results = ExamResult::query()
        ->with('subject')
        ->where('exam_id',$exam->id)
        ->where('student_id', $student->id)
        ->orderBy('subject_id')
        ->get();

        $totalMarks = $results->sum('marks');
        $average = $results->count() ? round($results->avg('marks'),2):null;

        return view('admin.reports.student',[
            'student'=>$student->load('user','activeEnrollment.schoolClass'),
            'exam'=>$exam,
            'results'=>$results,
            'totalMarks'=>$totalMarks,
            'average'=>$average,
        ]);

    }
    public function pdf(Student $student, Exam $exam){
       $results = ExamResult::query()
        ->with('subject')
        ->where('exam_id', $exam->id)
        ->where('student_id', $student->id)
        ->orderBy('subject_id')
        ->get();

    $totalMarks = $results->sum('marks');
    $average = $results->count()
        ? round($results->avg('marks'), 2)
        : null;

        $pdf = Pdf::loadView('admin.reports.student-pdf',[
            'student'=>$student->load('user','activeEnrollment.schoolClass'),
            'exam'=>$exam,
            'results'=>$results,
            'totalMarks'=>$totalMarks,
            'average'=>$average
        ])->setPaper('a4');

       return $pdf->download(
        str($student->user?->name)->slug('_')
        . '_' . str($exam->name)->slug('_')
        . '_report.pdf'
    );
    }
}
