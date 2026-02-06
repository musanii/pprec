<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Term;
use Illuminate\Database\Seeder;
use RuntimeException;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = AcademicYear::query()->where('is_active', true)->first();

        if (! $year) {
            throw new RuntimeException('No active Academic Year found. Run AcademicYearSeeder first');
        }

        // Adjust dates to match your school calendar later
        $terms = [
            [
                'name' => 'Term 1',
                'start_date' => '2026-01-06',
                'end_date' => '2026-04-04',
                'is_active' => true, // default active term
            ],
            [
                'name' => 'Term 2',
                'start_date' => '2026-05-05',
                'end_date' => '2026-08-02',
                'is_active' => false,
            ],
            [
                'name' => 'Term 3',
                'start_date' => '2026-09-02',
                'end_date' => '2026-11-28',
                'is_active' => false,
            ],
        ];

        foreach ($terms as $t) {
            Term::updateOrCreate(
                [
                    'academic_year_id' => $year->id,
                    'name' => $t['name'],
                ],
                [
                    'start_date' => $t['start_date'],
                    'end_date' => $t['end_date'],
                    'is_active' => $t['is_active'],
                ]
            );
        }

    }
}
