<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Training::factory()->count(100)->create()->each(function (Training $training) {
            $training->load('courses');
            $training->courses->each(function(Course $course) use($training) {
                $training->load('trainings');
                $course->trainings()->attach($training);
            });
        });
    }
}
