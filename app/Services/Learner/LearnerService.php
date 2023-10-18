<?php

namespace App\Services\Learner;

use App\Models\Mode;
use App\Models\Learner;
use Illuminate\Support\Collection;

class LearnerService
{
    public static function getLearnerModes(): Collection
    {
        return Mode::all();
    }

    public static function getLearners(): Collection
    {
        return Learner::all();
    }
}
