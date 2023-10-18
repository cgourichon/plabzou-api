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

    public static function getTeachers(): Collection
    {
        return Teacher::all();
    }
}
