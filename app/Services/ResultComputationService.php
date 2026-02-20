<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\GradeBoundary;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ResultComputationService
{
    protected $gradeBoundaries;

    public function __construct()
    {
        $this->gradeBoundaries = GradeBoundary::where('is_active', true)->get();
    }

    public function computeExam(Exam $exam)
    {

        if ($exam->aggregates()->where('is_locked', true)->exists()) {
            throw ValidationException::withMessages([
                'exam' => 'This exam is locked and cannot be recomputed.',
            ]);
        }

                if ($exam->is_published) {
            throw ValidationException::withMessages([
                'exam' => 'Published exams cannot be recomputed.'
            ]);
        }
        DB::transaction(function () use ($exam) {

            $results = ExamResult::where('exam_id', $exam->id)
                ->whereNotNull('marks')
                ->get()
                ->groupBy('student_id');

            foreach ($results as $studentId => $subjects) {

                $total = 0;
                $subjectCount = 0;

                foreach ($subjects as $result) {

                    $total += $result->marks;
                    $subjectCount++;
                    $grade = $this->resolveGrade($result->marks);

                    $result->update([
                        'grade' => $grade['grade'],
                    ]);
                }

                $mean = $subjectCount > 0
                    ? $total / $subjectCount
                    : 0;

                $hash = hash(
                    'sha256',
                    $exam->id.
                    $studentId.
                    $total.
                    round($mean, 2)
                );

                
                $exam->aggregates()->updateOrCreate(
                    ['student_id' => $studentId],
                    [
                        'total_marks' => $total,
                        'mean_score' => round($mean, 2),
                        'result_hash' => $hash,
                    ]
                );
            }

            $this->rankClass($exam);
            $this->rankStream($exam);
        });
    }

    public function resolveGrade($marks)
    {
        foreach ($this->gradeBoundaries as $boundary) {
            if ($marks >= $boundary->min_score && $marks <= $boundary->max_score) {
                return $boundary;
            }

        }

        return ['grade' => null];
    }

    protected function rankClass(Exam $exam)
    {
        $aggregates = $exam->aggregates()
            ->orderByDesc('total_marks')
            ->get();

        $rank = 1;
        $previousScore = null;
        $position = 1;

        foreach ($aggregates as $aggregate) {
            if ($previousScore !== null && $aggregate->total_marks < $previousScore) {
                $position = $rank;

            }
            $aggregate->update([
                'class_rank' => $position,
            ]);

            $previousScore = $aggregate->total_marks;
            $rank++;
        }
    }

    protected function rankStream(Exam $exam)
    {

        $aggregates = $exam->aggregates()
            ->get()
            ->groupBy('stream_id');

            foreach($aggregates as $streamId=>$streamGroup){
                $sorted = $streamGroup->sortByDesc('total_marks')->values();

                $rank = 1;
                $previousScore = null;
                $position = 1;
                 foreach( $sorted as $aggregate)
                    {
                        if($previousScore !== null && $aggregate->total_marks < $previousScore)
                            {
                                $position= $rank;
                            }

                            $aggregate->update([
                                'stream_rank'=>$position
                            ]);

                            $previousScore = $aggregate->total_marks;
                            $rank++;

                    }

            }



       

    }
}
