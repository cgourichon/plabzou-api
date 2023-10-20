<?php
namespace App\Services\Request;

use App\Models\Request;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

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

        if (is_null($validated['is_approved_by_teacher']) && !is_null($validated['is_approved_by_admin'])) {
            throw new InvalidArgumentException("Vous ne pouvez pas valider/rejetter cette demande tant que le formateur n'y a pas répondu");
        }

        $request->update($validated);
        return $request;
    }

    /**
     * Permet de créer une nouvelle demande
     *
     * @param array $validated
     * @return mixed
     * @throws ValidationException
     */
    public static function createRequest(array $validated) : Request
    {
        $existingRequest = Request::where('timeslot_id', '=', $validated['timeslot_id'])
                                    ->where('teacher_id', '=', $validated['teacher_id'])
                                    ->first();

        if ($existingRequest) {
            throw new InvalidArgumentException('Une demande existe déjà sur ce créneau pour ce formateur');
        }

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
