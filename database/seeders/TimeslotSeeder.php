<?php

namespace Database\Seeders;

use App\Models\Learner;
use App\Models\Teacher;
use App\Models\Timeslot;
use Illuminate\Database\Seeder;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timeslot::factory()->count(100)->create()->each(function (Timeslot $timeslot) {
            $teachers = Teacher::inRandomOrder()->limit(rand(1, 5))->get();
            $timeslot->teachers()->attach($teachers);

            $learners = Learner::inRandomOrder()->limit(rand(1, 10))->get();
            $timeslot->learners()->attach($learners);
        });
    }
}
