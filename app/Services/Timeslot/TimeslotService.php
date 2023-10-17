<?php

namespace App\Services\Timeslot;

use App\Models\Timeslot;
use Illuminate\Support\Collection;

class TimeslotService
{
    public static function getTimeslots(): Collection
    {
        return Timeslot::with(['room', 'training', 'teachers', 'learners'])->get();
    }

    public static function createTimeslot(array $data): Timeslot
    {
        $timeslot = Timeslot::create(self::formatTimeslotData($data));
        $timeslot->learners()->attach(collect($data['learners'])->pluck('id'));
        $timeslot->teachers()->attach(collect($data['teachers'])->pluck('id'));

        return $timeslot;
    }

    public static function updateTimeslot(Timeslot $timeslot, array $data): Timeslot
    {
        $timeslot->update(self::formatTimeslotData($data));
        $timeslot->learners()->sync($data['learners']);
        $timeslot->teachers()->sync($data['teachers']);

        return $timeslot;
    }

    private static function formatTimeslotData(array $data): array
    {
        return [
            'training_id' => $data['training'],
            'room_id' => $data['room'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'is_validated' => (bool)$data['is_validated'],
        ];
    }
}
