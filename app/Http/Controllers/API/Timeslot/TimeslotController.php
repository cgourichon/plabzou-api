<?php

namespace App\Http\Controllers\API\Timeslot;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Timeslot\TimeslotRequest;
use App\Models\Timeslot;
use App\Services\Timeslot\TimeslotService;

class TimeslotController extends BaseController
{
    public function index()
    {
        $timeslots = TimeslotService::getTimeslots();

        return $this->success($timeslots->toArray(), 'Créneaux récupérés avec succès.');
    }

    public function store(TimeslotRequest $request)
    {
        $timeslot = TimeslotService::createTimeslot($request->validated());

        return $this->success($timeslot->toArray(), 'Créneau créé avec succès.');
    }

    public function show(Timeslot $timeslot)
    {
        $timeslot->load(['room', 'training', 'teachers', 'learners']);

        return $this->success($timeslot->toArray(), 'Créneau récupéré avec succès.');
    }

    public function update(TimeslotRequest $request, Timeslot $timeslot)
    {
        $timeslot = TimeslotService::updateTimeslot($timeslot, $request->validated());

        return $this->success($timeslot->toArray(), 'Créneau mis à jour avec succès.');
    }

    public function destroy(Timeslot $timeslot)
    {
        $timeslot->delete();

        return $this->success([], 'Créneau supprimé avec succès.');
    }
}
