<?php

namespace App\Services\Timeslot;

use App\Models\Timeslot;
use App\Services\Request\RequestService;
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

            RequestService::createRequests($timeslot);

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
     * Récupérer les créneaux avec la même période (entre le début et la fin du créneau)
     *
     * @param string $startsAt
     * @param string $endsAt
     * @return Collection
     */
    private static function getTimeslotsSamePeriod(string $startsAt, string $endsAt): Collection
    {
        return Timeslot::with(['learners', 'teachers'])
            ->where('starts_at', '>=', $startsAt)
            ->where('ends_at', '<=', $endsAt)
            ->get();
    }

    /**
     * Vérifier la disponibilité d'une salle pour des créneaux
     *
     * @param Collection $timeslots
     * @param int $roomId
     * @return bool
     */
    private static function checkRoomAvailabilityForTimeslots(Collection $timeslots, int $roomId): bool
    {
        return $timeslots->where('room_id', $roomId)->isEmpty();
    }

    /**
     * Verifier la disponibilité des utilisateurs (apprenants/learners et formateurs/teachers) pour des créneaux
     *
     * @param Collection $timeslots
     * @param array $usersToCheck
     * @param string $userRelation
     * @return bool
     */
    private static function checkUsersAvailabilityForTimeslots(Collection $timeslots, array $usersToCheck, string $userRelation): bool
    {
        $userIdsFromData = collect($usersToCheck)->pluck('user_id');
        $userIdsFromTimeslots = $timeslots->pluck($userRelation)->flatten()->pluck('user_id');

        return $userIdsFromData->intersect($userIdsFromTimeslots)->isEmpty();
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
        $timeslotsSamePeriod = self::getTimeslotsSamePeriod($data['starts_at'], $data['ends_at']);

        // Vérifier si l'on met à jour un créneau
        if ($timeslot) {
            $timeslotsSamePeriod = $timeslotsSamePeriod->where('id', '!=', $timeslot->id);
        }

        // Vérifier si le créneau est disponible et renvoyer une exception si ce n'est pas le cas

        if (!self::checkRoomAvailabilityForTimeslots($timeslotsSamePeriod, $data['room'])) {
            throw new InvalidArgumentException('Le créneau est déjà pris sur cette salle.');
        }

        if (!self::checkUsersAvailabilityForTimeslots($timeslotsSamePeriod, $data['learners'], 'learners')) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs apprenants.');
        }

        if (!self::checkUsersAvailabilityForTimeslots($timeslotsSamePeriod, $data['teachers'], 'teachers')) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs formateurs.');
        }
    }
}
