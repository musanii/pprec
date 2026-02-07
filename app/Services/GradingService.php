<?php

namespace App\Services;
class GradingService
{
    public function grade(float $marks): string
    {
        return match (true) {
            $marks >= 80 => 'A',
            $marks >= 70 => 'B',
            $marks >= 60 => 'C',
            $marks >= 50 => 'D',
            default      => 'E',
        };
    }

    public function remark(string $grade): string
    {
        return match ($grade) {
            'A' => 'Excellent',
            'B' => 'Very Good',
            'C' => 'Good',
            'D' => 'Fair',
            default => 'Needs Improvement',
        };
    }
}
