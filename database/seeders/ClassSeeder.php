<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Stream;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $classes = [
            ['name'=>'Playgroup','level'=>0],
            ['name' => 'PP1', 'level' => 1],
            ['name' => 'PP2', 'level' => 2],
            ['name' => 'Grade 1', 'level' => 3],
            ['name' => 'Grade 2', 'level' => 4],
            ['name' => 'Grade 3', 'level' => 5],
            ['name' => 'Grade 4', 'level' => 6],
            ['name' => 'Grade 5', 'level' => 7],
            ['name' => 'Grade 6', 'level' => 8],
        ];

        // Default streams used by many schools
        $defaultStreams = ['A', 'B'];

        foreach($classes as $c){
            $class = SchoolClass::updateOrCreate(
                ['name' => $c['name']],
                ['level' => $c['level']]
            );

            foreach ($defaultStreams as $streamName) {
                Stream::updateOrCreate(
                    ['class_id' => $class->id, 'name' => $streamName],
                    ['is_active' => true] // or 1
                );
            }

        }
    }
}
