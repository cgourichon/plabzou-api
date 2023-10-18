<?php

namespace App\Services\Timeslot;

use App\Models\Timeslot;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class TimeslotService
{
    public static function getTimeslots(): Collection
    {
        return Timeslot::with(['room', 'training', 'teachers', 'learners'])->get();
    }

    /**
     * @throws Exception
     */
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

    /**
     * @throws Exception
     */
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

    /**
     * Vérifier la disponibilité d'un créneau
     *
     * @param array $data
     * @param Timeslot|null $timeslot
     * @return void
     */
    public static function checkTimeslotAvailability(array $data, ?Timeslot $timeslot = null): void
    {
        // Récupérer les créneaux avec la même période (entre le début et la fin du créneau)
        $timeslotsSamePeriod = Timeslot::with(['learners', 'teachers'])
            ->where('starts_at', '>=', $data['starts_at'])
            ->where('ends_at', '<=', $data['ends_at'])
            ->get();

        // Vérifier si l'on met à jour un créneau
        if ($timeslot) {
            $timeslotsSamePeriod = $timeslotsSamePeriod->where('id', '!=', $timeslot->id);
        }

        // Récupérer les créneaux avec la même salle
        $timeslotsSameRoom = $timeslotsSamePeriod->where('room_id', $data['room']);

        // Vérifier la disponibilité de la salle
        $availableForRoom = $timeslotsSameRoom->isEmpty();

        // Récupérer les id des apprenants et des formateurs
        $learnerIdsFromData = collect($data['learners'])->pluck('user_id');
        $learnerIdsFromTimeslots = $timeslotsSamePeriod->pluck('learners')->flatten()->pluck('user_id');
        $teacherIdsFromData = collect($data['teachers'])->pluck('user_id');
        $teacherIdsFromTimeslots = $timeslotsSamePeriod->pluck('teachers')->flatten()->pluck('user_id');

        // Vérifier la disponibilité des apprenants et des formateurs
        $availableForLearners = $learnerIdsFromData->intersect($learnerIdsFromTimeslots)->isEmpty();
        $availableForTeachers = $teacherIdsFromData->intersect($teacherIdsFromTimeslots)->isEmpty();

        // Vérifier si le créneau est disponible et renvoyer une exception si ce n'est pas le cas

        if (!$availableForRoom) {
            throw new InvalidArgumentException('Le créneau est déjà pris sur cette salle.');
        }

        if (!$availableForLearners) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs apprenants.');
        }

        if (!$availableForTeachers) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs formateurs.');
        }
    }
}
