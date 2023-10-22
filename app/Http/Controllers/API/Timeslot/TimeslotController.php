<?php

namespace App\Http\Controllers\API\Timeslot;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Timeslot\TimeslotRequest;
use App\Models\Timeslot;
use App\Services\Timeslot\TimeslotService;
use Exception;
use InvalidArgumentException;

class TimeslotController extends BaseController
{
    public function index()
    {
        $timeslots = TimeslotService::getTimeslots();

        return $this->success($timeslots->toArray(), 'Créneaux récupérés avec succès.');
    }

    public function store(TimeslotRequest $request)
    {
        $validatedData = $request->validated();

        try {
            TimeslotService::checkTimeslotAvailability($validatedData);

            $timeslot = TimeslotService::createTimeslot($validatedData);

            return $this->success($timeslot->toArray(), 'Créneau créé avec succès, demandes envoyées aux formateurs.');
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (Exception $e) {
            return $this->error('Une erreur est survenue lors de la création du créneau.');
        }
    }

    public function show(Timeslot $timeslot)
    {
        $timeslot->load(['room', 'training', 'teachers', 'learners', 'promotions', 'promotions.learners', 'promotions.course']);

        return $this->success($timeslot->toArray(), 'Créneau récupéré avec succès.');
    }

    public function update(TimeslotRequest $request, Timeslot $timeslot)
    {
        $validatedData = $request->validated();

        try {
            TimeslotService::checkTimeslotAvailability($validatedData, $timeslot);

            $timeslot = TimeslotService::updateTimeslot($timeslot, $validatedData);

            return $this->success($timeslot->toArray(), 'Créneau mis à jour avec succès.');
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (Exception $e) {
            return $this->error('Une erreur est survenue lors de la modification du créneau.');
        }
    }

    public function destroy(Timeslot $timeslot)
    {
        $timeslot->requests()->delete();
        $timeslot->delete();

        return $this->success([], 'Créneau supprimé avec succès.');
    }
}
