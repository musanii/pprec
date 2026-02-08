<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExamStreamRankingController extends Controller
{
    public function index(Exam $exam, SchoolClass $class, Stream $stream)
    {
        $results = ExamResult::query()
        ->where('exam_id', $exam->id)
        ->where('class_id', $class->id)
        ->whereHas('student.activeEnrollment', function($q) use ($stream) {
            $q->where('stream_id', $stream->id);
        })
        ->with('student.user')
        ->get()
        ->groupBy('student_id');

        $rankings= $results->map(function(Collection $rows){
            return[
                'student'=>$rows->first()->student,
                'total'=>$rows->sum('marks'),
                'average'=>round($rows->avg('marks'), 2),
            ];
            
        })->sortByDesc('total')
        ->values();

        $position =0;
        $lastScore=null;
        $rank=0;

        $rankings = $rankings->map(function ($row) use (&$position, &$lastScore, &$rank) {
            $position++;

            if ($row['total'] !== $lastScore) {
                $rank = $position;
                $lastScore = $row['total'];
            }

            $row['position'] = $rank;
            return $row;
        });

        return view('admin.exams.rankings', 
        compact('exam', 'class', 'stream', 'rankings'));
    }
}
