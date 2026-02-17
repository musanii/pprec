<?php

namespace Database\Seeders;

use App\Models\GradeBoundary;
use Illuminate\Database\Seeder;

class GradeBoundarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GradeBoundary::insert([

            ['grade' => 'A', 'min_score' => 80, 'max_score' => 100, 'points' => 12],
            ['grade' => 'A-', 'min_score' => 75, 'max_score' => 79.99, 'points' => 11],
            ['grade' => 'B+', 'min_score' => 70, 'max_score' => 74.99, 'points' => 10],
            ['grade' => 'B', 'min_score' => 65, 'max_score' => 69.99, 'points' => 9],
            ['grade' => 'C+', 'min_score' => 60, 'max_score' => 64.99, 'points' => 8],
            ['grade' => 'C', 'min_score' => 55, 'max_score' => 59.99, 'points' => 7],
            ['grade' => 'D', 'min_score' => 40, 'max_score' => 54.99, 'points' => 6],
            ['grade' => 'E', 'min_score' => 0, 'max_score' => 39.99, 'points' => 1],

        ]);
    }
}
