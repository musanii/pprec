<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Term;
use Illuminate\Http\Request;

class ResultController extends Controller
{

   public function index()
   {
    $student = auth()->user()->student;

  
        $terms = Term::whereHas('enrollments', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        })
        ->orderBy('start_date', 'desc')
        ->get();
      return view('student.results.index', compact('terms'));
   }

   public function show(Term $term){
    $student = auth()->user()->student;

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
        $overallAverage = $subjects->count() ? round($subjects->avg('average'),2) : null;

        return view('student.results.show', 
        [
             'student'=>$student,
            'term'=>$term,
            'exams'=>$exams,
            'subjects'=>$subjects,
            'overallTotal'=>$overallTotal,
            'overallAverage'=>$overallAverage,
        ]);
   }
}
