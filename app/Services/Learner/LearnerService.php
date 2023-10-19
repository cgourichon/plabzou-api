<?php

namespace App\Services\Learner;

use App\Models\Learner;
use App\Models\Mode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LearnerService
{
    public static function getLearnerModes(): Collection
    {
        return Mode::all();
    }

    public static function getLearners(array $parameters): Collection
    {
        $query = Learner::query();

        if (array_key_exists('training', $parameters)) {
            $query->whereHas('promotions.course.trainings', function (Builder $query) use ($parameters) {
                $query->where('training_id', $parameters['training']);
            });
        }

        return $query->get();
    }
}
