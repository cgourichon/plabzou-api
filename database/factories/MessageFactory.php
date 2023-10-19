<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Teacher;
use App\Services\AdministrativeEmployee\AdministrativeEmployeeService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teacher = Teacher::inRandomOrder()->first()->user_id;
        $admins = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        $all = $admins->merge($teacher);

        return [
            'sender_id' => $all->random(),
            'conversation_id' => Conversation::all()->random()->first()->id,
            'message' => $this->faker->sentence()
        ];
    }
}
