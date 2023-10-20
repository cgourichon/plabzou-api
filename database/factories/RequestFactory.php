<?php

namespace Database\Factories;

use App\Models\AdministrativeEmployee;
use App\Models\Teacher;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $choices = collect([true, false, null]);

        return [
            'teacher_id' => Teacher::all()->random()->user_id,
            'administrative_employee_id' => AdministrativeEmployee::all()->random()->user_id,
            'timeslot_id' => Timeslot::all()->random()->id,
            'comment' => $this->faker->sentence,
            'is_approved_by_admin' => $choices->random(),
            'is_approved_by_teacher' => $choices->random(),
        ];
    }
}
