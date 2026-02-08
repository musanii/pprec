<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Http\Request;

class TermReportController extends Controller
{
    public function show(Student $student, Term $term){
        $exams = Exam::where('term_id', $term->id)
        ->where('is_published', true)
        ->orderBy('start_date')
        ->get();

        $results = ExamResult::query()
        ->with('subject')
        ->where('student_id', $student->id)
        ->whereIn('exam_id', $exams->pluck('id'))
        ->get()
        ->groupBy('subject_id');

        //subject rows
        $subjects = $results->map(function($rows){
            return[
                'subject'=>$rows->first()->subject,
                'total'=>$rows->sum('marks'),
                'average'=>round($rows->avg('marks'), 2),
                'exams'=>$rows->keyBy('exam_id')
            ];
        });

        //overall totals
        $overallTotal = $subjects->sum('total');
        $overallAverage = $subjects->count() ? round($subjects->avg('average'), 2) : null;

        return view('admin.reports.term',[
            'student'=>$student->load('user', 'activeEnrollment.schoolClass'),
            'term'=>$term,
            'exams'=>$exams,
            'subjects'=>$subjects,
            'overallTotal'=>$overallTotal,
            'overallAverage'=>$overallAverage,
        ]);

    }
}
