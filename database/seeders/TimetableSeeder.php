<?php

namespace Database\Seeders;

use App\Models\TimeTableSlot;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeTableSlot::create([
            'academic_year_id' => 1,
            'term_id' => 1,
            'class_id' => 1,
            'stream_id' => null,
            'school_period_id' => 1,
            'subject_id' => 1,
            'teacher_id' => 1,
            'day_of_week' => 'monday',

        ]);
    }
}
