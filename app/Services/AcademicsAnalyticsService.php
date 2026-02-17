<?php 
namespace App\Services;

use App\Models\ExamResult;
use App\Models\Term;
use Illuminate\Support\Facades\DB;                                             


class AcademicsAnalyticsService{

public function termOverview(?int $termId=null)
{
    $term = $termId ? Term::findOrFail($termId) : Term::where('is_active', true)->firstOrFail();                

    $results = ExamResult::query()
    ->whereHas('exam', fn($q) => $q->where('term_id', $term->id))
    ->whereNotNull('marks');

    $overallMean= (clone $results)->avg('marks');  
    $overalEntries = (clone $results)->count();
    
    return [
        'term' => $term->name,
        'overall_mean' => round($overallMean ?? 0, 2),
        'entries' => $overalEntries,
    ];
}



public function classPerformance(int $termId)
{
    return ExamResult::query()
        ->join('classes', 'exam_results.class_id', '=', 'classes.id')
        ->whereHas('exam', fn ($q) => $q->where('term_id', $termId))
        ->whereNotNull('marks')
        ->groupBy('exam_results.class_id', 'classes.name')
        ->select(
            'exam_results.class_id',
            'classes.name as class_name',
            DB::raw('AVG(marks) as mean_score')
        )
        ->orderByDesc('mean_score')
        ->get();
}


public function subjectPerformance(int $termId)
{
    return ExamResult::query()
        ->join('subjects', 'exam_results.subject_id', '=', 'subjects.id')
        ->whereHas('exam', fn ($q) => $q->where('term_id', $termId))
        ->whereNotNull('marks')
        ->groupBy('exam_results.subject_id', 'subjects.name')
        ->select(
            'exam_results.subject_id',
            'subjects.name as subject_name',
            DB::raw('AVG(marks) as mean_score')
        )
        ->orderByDesc('mean_score')
        ->get();
}



public function topStudents(int $termId, int $limit = 5)
{
    return ExamResult::query()
        ->join('students', 'exam_results.student_id', '=', 'students.id')
        ->join('users', 'students.user_id', '=', 'users.id')
        ->whereHas('exam', fn ($q) => $q->where('term_id', $termId))
        ->whereNotNull('marks')
        ->groupBy('exam_results.student_id', 'users.name')
        ->select(
            'exam_results.student_id',
            'users.name as student_name',
            DB::raw('AVG(marks) as mean_score')
        )
        ->orderByDesc('mean_score')
        ->limit($limit)
        ->get();
}



    public function bottomStudents(int $termId, int $limit = 5)
    {
        return ExamResult::query()
            ->select(
                'student_id',
                DB::raw('AVG(marks) as mean_score')
            )
            ->whereHas('exam', fn ($q) => $q->where('term_id', $termId))
            ->groupBy('student_id')
            ->with('student.user')
            ->orderBy('mean_score')
            ->limit($limit)
            ->get();
    }



}
