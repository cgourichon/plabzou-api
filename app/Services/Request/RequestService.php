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
        return Request::with('teacher', 'timeslot', 'administrativeEmployee')->withTrashed()->get();
    }

    /**
     * Permet de créer les demandes à la création du créneau
     *
     * @param Timeslot $timeslot
     * @return void
     */
    public static function createRequests(Timeslot $timeslot): void
    {
        $timeslot->load('teachers');
        $teachers  = $timeslot->teachers;

        foreach ($teachers as $teacher) {

            dump($teacher, $timeslot->id);

            Request::create([
               'teacher_id' => $teacher->user_id,
               'timeslot_id' => $timeslot->id,
               'administrative_employee_id' => Auth::id()
            ]);
        }
    }
}
