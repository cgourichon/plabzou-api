<?php

namespace Database\Factories;

use App\Models\AdministrativeEmployee;
use App\Models\Conversation;
use App\Models\Teacher;
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
        return [
            'sender_id' => AdministrativeEmployee::all()->random()->user_id,
            'conversation_id' => Conversation::all()->random()->user_id,
            'message' => $this->faker->text()
        ];
    }
}
