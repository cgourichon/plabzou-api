<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Training::factory()->count(20)->create()->each(function (Training $training) {
            $training->teachers()->attach(Teacher::inRandomOrder()->limit(rand(1, 5))->get());
        });
    }
}
