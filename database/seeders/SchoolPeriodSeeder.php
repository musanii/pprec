<?php

namespace Database\Seeders;

use App\Models\SchoolPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolPeriod::insert([
    ['name'=>'P1','period_number'=>1,'start_time'=>'08:00','end_time'=>'08:40'],
    ['name'=>'P2','period_number'=>2,'start_time'=>'08:40','end_time'=>'09:20'],
    ['name'=>'Break','period_number'=>3,'start_time'=>'09:20','end_time'=>'09:40','is_break'=>true],
    ['name'=>'P3','period_number'=>4,'start_time'=>'09:40','end_time'=>'10:20'],
]);
    }
}
