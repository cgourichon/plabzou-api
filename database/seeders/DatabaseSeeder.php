<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModeSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            CitySeeder::class,
            PlaceSeeder::class,
            BuildingSeeder::class,
            RoomSeeder::class,
            TrainingSeeder::class,
        ]);
    }
}
