<?php

namespace Database\Seeders;

use App\Models\Message;
use Database\Factories\MessageTeacherFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory()
            ->count(50)
            ->create();
    }
}
