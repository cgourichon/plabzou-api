<?php

namespace Database\Seeders;

use App\Models\Learner;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::factory()->count(25)->create()->each(function(Promotion $promotion){
            $learners = Learner::inRandomOrder()->limit(rand(1, 10))->get();
            $promotion->learners()->attach($learners);
            $promotion->course->load('promotions');

            $promotion->course->promotions->add($promotion);
        });
    }
}
