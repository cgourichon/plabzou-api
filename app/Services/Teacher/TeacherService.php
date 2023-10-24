<?php

namespace App\Services\Teacher;

use App\Enums\StatusEnum;
use App\Models\Teacher;
use Illuminate\Support\Collection;

class TeacherService
{
    public static function getTeacherStatuses(): array
    {
        return collect(StatusEnum::cases())->pluck('value')->toArray();
    }

    public static function getTeachers(array $parameters): Collection
    {
        $query = Teacher::query();

        if (array_key_exists('training', $parameters))
            $query->whereRelation('trainings', 'trainings.id', '=', $parameters['training']);

        return $query->with('requests')->get();
    }
}
