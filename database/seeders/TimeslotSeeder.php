<?php

namespace Database\Seeders;

use App\Models\Learner;
use App\Models\Teacher;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timeslot::factory()->count(50)->create()->each(function (Timeslot $timeslot) {
            $teachers = Teacher::whereRelation('trainings', 'trainings.id', '=', $timeslot->training_id)
                ->inRandomOrder()->limit(rand(1, 10))
                ->get();

            $timeslot->teachers()->attach($teachers->random(rand(1, $teachers->count())));

            $learners = Learner::with(['promotions.course.trainings'])
                ->whereHas('promotions.course.trainings', function (Builder $query) use ($timeslot) {
                    $query->where('training_id', $timeslot->training_id);
                })->inRandomOrder()->limit(rand(1, 5))->get();

            $timeslot->learners()->attach($learners);
        });
    }
}
