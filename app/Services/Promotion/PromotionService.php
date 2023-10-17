<?php

namespace App\Services\Promotion;

use App\Models\Promotion;
use Illuminate\Support\Collection;

class PromotionService
{
    public static function getPromotions(): Collection
    {
        return Promotion::with(['course', 'learners', 'city'])->get();
    }
}
