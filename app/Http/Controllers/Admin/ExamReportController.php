<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExamReportController extends Controller
{
    public function show(Exam $exam, Student $student)
    {
        abort_unless($exam->is_published,403);

        $aggregate = $exam->aggregates()
        ->where('student_id', $student->id)
        ->firstOrFail();

        $subjects = $exam->results()
        ->where('student_id', $student->id)->with('subject')->get();

        $pdf = Pdf::loadView(
            'admin.exams.report-card',
            compact('exam','student','aggregate','subjects')
        );

        return $pdf->stream('report-card-'.$student->id.'.pdf');
    }
}
