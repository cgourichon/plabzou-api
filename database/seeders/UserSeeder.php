<?php

namespace Database\Seeders;

use App\Models\AdministrativeEmployee;
use App\Models\Conversation;
use App\Models\Learner;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdministrativeEmployee::factory()->count(10)->create();
        Teacher::factory()
            /*
            ->hasMessages(4, [
                'conversation_id' => Conversation::all()->random()->id,
                'message' => 'Test de message de la part du formateur'
            ])*/
            ->count(15)
            ->create();

        Learner::factory()->count(30)->create();
    }
}
