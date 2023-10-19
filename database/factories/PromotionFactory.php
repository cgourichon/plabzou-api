<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('now', '+90 days');

        $startDate->setTime(0, 0, 0);

        $duration = $this->faker->randomElement([300, 320, 340, 360, 380]);

        $endDate = clone $startDate;
        $endDate->modify('+' . $duration . ' days');


        return [
            'name' => $this->faker->name(),
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'course_id' => Course::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
        ];
    }
}
