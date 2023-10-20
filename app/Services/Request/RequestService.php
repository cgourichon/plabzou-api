<?php

namespace App\Services\Request;

use App\Models\Request;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RequestService
{

    /**
     * Permet de récupérer la liste des requêtes avec le formateur, l'admin et le créneau associé
     * y compris les demandes annulées
     *
     * @return Builder[]|Collection
     */
    public static function getRequestsWithRelations(): Collection|array
    {
        return Request::with('teacher', 'timeslot.training', 'administrativeEmployee')->withTrashed()->get();
    }

    /**
     * Permet de retrouver une requête précise avec ses relations
     *
     * @param Request $request
     * @return Request
     */
    public static function getRequestWithRelation(Request $request)
    {
        $request->load('teacher', 'timeslot.training', 'administrativeEmployee');
        return $request;
    }

    /**
     * Permet de créer les demandes à partir de la création du créneau
     *
     * @param Timeslot $timeslot
     * @return void
     */
    public static function createRequests(Timeslot $timeslot): void
    {
        $timeslot->load('teachers');
        $teachers  = $timeslot->teachers;

        foreach ($teachers as $teacher) {

            Request::create([
               'teacher_id' => $teacher->user_id,
               'timeslot_id' => $timeslot->id,
               'administrative_employee_id' => Auth::id()
            ]);
        }
    }

    /**
     * Permet de mettre à jour une demande
     *
     * @param Request $request
     * @param array $validated
     * @return Request
     */
    public static function updateRequest(Request $request, array $validated): Request
    {
        $request->update($validated);
        return $request;
    }

    /**
     * Permet de créer une nouvelle demande
     *
     * @param array $validated
     * @return mixed
     */
    public static function createRequest(array $validated) : Request
    {
        return Request::create($validated);
    }

    /**
     * @param Request $request
     * @return void
     */
    public static function deleteRequest(Request $request): void
    {
        $request->delete();
    }
}
