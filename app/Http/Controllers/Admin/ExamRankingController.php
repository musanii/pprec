<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExamRankingController extends Controller
{
    public function index(Exam $exam, SchoolClass $class)
    {
        // Fetch students in the class with their total marks for the exam
       $results = ExamResult::query()
       ->where('exam_id', $exam->id)
       ->where('class_id', $class->id)
       ->with('student.user')
       ->get()
       ->groupBy('student_id');

       $rankings = $results->map(function(Collection $rows){
        return[
            'student'=>$rows->first()->student,
            'total'=>$rows->sum('marks'),
            'average'=>round($rows->avg('marks'),2)
        ];

       })
       ->sortByDesc('total')
         ->values();

         $position = 0;
         $lastscore = null;
         $rank = 0;
         $rankings = $rankings->map(function($row) use (&$position ,&$lastscore,&$rank){
            $position++;
            if($row['total'] !== $lastscore){
                $rank = $position;
                $lastscore = $row['total'];
            }
            $row['position'] = $rank;
            return $row;
         });

         return view('admin.exams.rankings',[
            'exam'=>$exam,
            'class'=>$class,
            'rankings'=>$rankings
         ]);
    }
}
