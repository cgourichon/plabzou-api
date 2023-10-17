<?php

namespace App\Services\Timeslot;

use App\Models\Timeslot;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimeslotService
{
    public static function getTimeslots(): Collection
    {
        return Timeslot::with(['room', 'training', 'teachers', 'learners'])->get();
    }

    public static function createTimeslot(array $data): Timeslot
    {
        DB::beginTransaction();

        try {
            $timeslot = Timeslot::create(self::formatTimeslotData($data));
            $timeslot->learners()->attach(collect($data['learners'])->pluck('user_id'));
            $timeslot->teachers()->attach(collect($data['teachers'])->pluck('user_id'));

            DB::commit();

            return $timeslot;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function updateTimeslot(Timeslot $timeslot, array $data): Timeslot
    {
        DB::beginTransaction();

        try {
            $timeslot->update(self::formatTimeslotData($data));
            $timeslot->learners()->sync(collect($data['learners'])->pluck('user_id'));
            $timeslot->teachers()->sync(collect($data['teachers'])->pluck('user_id'));

            DB::commit();

            return $timeslot;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
