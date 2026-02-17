<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\GradeBoundary;
use Illuminate\Support\Facades\DB;

class ResultComputationService
{
    protected $gradeBoundaries;

    public function __construct()
    {
        $this->gradeBoundaries = GradeBoundary::where('is_active', true)->get();
    }

  public function computeExam(Exam $exam)
{
    DB::transaction(function () use ($exam) {

        $results = ExamResult::where('exam_id', $exam->id)
            ->whereNotNull('marks')
            ->get()
            ->groupBy('student_id');

        foreach ($results as $studentId => $subjects) {

            $total = 0;
            $subjectCount = 0;

            foreach ($subjects as $result) {

                $total += $result->marks;   // 🔥 ADD THIS
                $subjectCount++;            // 🔥 ADD THIS

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
                $exam->id .
                $studentId .
                $total .
                round($mean, 2)
            );

            // 🔥 MOVE OUTSIDE inner loop
            $exam->aggregates()->updateOrCreate(
                ['student_id' => $studentId],
                [
                    'total_marks' => $total,
                    'mean_score' => round($mean, 2),
                    'result_hash' => $hash
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
        $exam->aggregates()
            ->orderByDesc('total_marks')
            ->get()
            ->each(function ($record, $index) {
                $record->update([
                    'class_rank' => $index + 1,
                ]);
            });
    }

    protected function rankStream(Exam $exam)
    {

        $exam->aggregates()
            ->get()
            ->groupBy('stream_id')
            ->each(function ($group) {
                $group->sortByDesc('total_marks')
                    ->values()
                    ->each(function ($record, $index) {
                        $record->update([
                            'stream_rank' => $index + 1,
                        ]);
                    });
            });

    }
}
