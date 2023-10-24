<?php

namespace App\Services\Timeslot;

use App\Models\Learner;
use App\Models\Room;
use App\Models\Timeslot;
use App\Models\Training;
use App\Services\Request\RequestService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class TimeslotService
{
    public static function getTimeslots(): Collection
    {
        return Timeslot::with(['room', 'training', 'teachers', 'learners', 'promotions'])->orderBy('starts_at', 'desc')->get();
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

            if (array_key_exists('promotions', $data))
                $timeslot->promotions()->attach(collect($data['promotions'])->pluck('id'));

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
            $timeslot->load('teachers.requests');
            $oldTeachers = $timeslot->teachers;

            $timeslot->update(self::formatTimeslotData($data));
            $timeslot->learners()->sync(collect($data['learners'])->pluck('user_id'));
            $timeslot->teachers()->sync(collect($data['teachers'])->pluck('user_id'));
            $timeslot->promotions()->sync(collect($data['promotions'])->pluck('id'));
            $timeslot->load('teachers.requests');
            RequestService::updateRequestsAfterUpdateTimeslot($oldTeachers, $timeslot->teachers, $timeslot);

            DB::commit();

            return $timeslot;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private static function formatTimeslotData(array $data): array
    {
        $formattedData = [
            'training_id' => $data['training'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'is_validated' => (bool)$data['is_validated'],
        ];

        if(isset($data['room'])) $formattedData['room_id'] = $data['room'];

        return $formattedData;
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
     * @param Room $room
     * @param Collection $timeslots
     * @return bool
     */
    private static function checkRoomAvailabilityForTimeslots(Room $room, Collection $timeslots): bool
    {
        return $timeslots->where('room_id', $room->id)->isEmpty();
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
     * Vérifier la durée totale de la formation pour les apprenants
     *
     * @param Timeslot|null $timeslot
     * @param Training $training
     * @param array $data
     * @return bool
     */
    private static function checkLearnersDuration(?Timeslot $timeslot, Training $training, array $data): bool
    {
        // Récupérer la durée totale de la formation (en minutes)
        $trainingDuration = $training->duration;
        // Récupérer la durée du créneau à créer (en minutes)
        $timeslotToCreateDuration = Carbon::parse($data['ends_at'])->diffInMinutes(Carbon::parse($data['starts_at']));

        // Pour chaque apprenant
        // Récupérer les créneaux de la formation
        // Et vérifier si la durée totale de la formation est dépassée
        foreach ($data['learners'] as $learner) {
            $learner = Learner::with('timeslots')->where('user_id', $learner['user_id'])->first();

            $timeslots = $learner->timeslots->where('training_id', $data['training']);
            $timeslots = $timeslot ? $timeslots->where('id', '!=', $timeslot->id) : $timeslots;

            $timeslotsDuration = $timeslots->sum(function ($timeslot) {
                return Carbon::parse($timeslot->ends_at)->diffInMinutes(Carbon::parse($timeslot->starts_at));
            });
            $totalDuration = $timeslotsDuration + $timeslotToCreateDuration;

            if ($totalDuration > $trainingDuration) {
                return false;
            }
        }

        return true;
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
        } else {
            if(!self::checkAuthorizationToCreate($data['starts_at'])) {
                throw new InvalidArgumentException("La création du créneau sur une date passée n'est pas autorisée");
            }
        }

        // Vérifier si le créneau est disponible et renvoyer une exception si ce n'est pas le cas

        if (isset($data['room'])){
            $room = Room::find($data['room']);

            if(!self::checkRoomAvailabilityForTimeslots($room, $timeslotsSamePeriod)) {
                throw new InvalidArgumentException('La salle est déjà utilisée pour un autre créneau.');
            }

            if(!self::checkRoomCapacity($room, $data['learners'])) {
                throw new InvalidArgumentException('La capacité maximale de la salle est dépassée.');
            }
        }

        if (!self::checkUsersAvailabilityForTimeslots($timeslotsSamePeriod, $data['learners'], 'learners')) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs apprenants.');
        }

        if (!self::checkUsersAvailabilityForTimeslots($timeslotsSamePeriod, $data['teachers'], 'teachers')) {
            throw new InvalidArgumentException('Le créneau est déjà pris pour un ou plusieurs formateurs.');
        }

        if (!self::checkLearnersDuration($timeslot, Training::find($data['training']), $data)) {
            throw new InvalidArgumentException('La durée totale de la formation est dépassée pour un ou plusieurs apprenants.');
        }
    }

    /**
     * Vérifie qu'il n'y a pas plus d'apprenants que de places disponibles
     *
     * @param $room
     * @param mixed $learners
     * @return bool
     */
    private static function checkRoomCapacity($room, mixed $learners): bool
    {
        return count($learners) <= $room->seats_number;
    }

    /**
     * Vérifie que le créneau n'est pas ajouté sur une date passée
     *
     * @param string $starts_at
     * @return bool
     */
    private static function checkAuthorizationToCreate(string $starts_at): bool
    {
        return Carbon::parse($starts_at) >= Carbon::now();
    }
}
