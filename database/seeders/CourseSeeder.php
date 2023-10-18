<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            ['name' => 'D2WM', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CDA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MS2D', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
