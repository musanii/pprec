<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::query()->update(['is_active'=>false]);

        AcademicYear::updateOrCreate(
            ['name'=>'2026'],
            [
            'start_date'=>'2026-01-01',
            'end_date'=>'2026-12-31',
            'is_active'=>true
            ]
        );
    }
}
