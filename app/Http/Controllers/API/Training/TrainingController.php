<?php

namespace App\Http\Controllers\API\Training;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Training\TrainingRequest;
use App\Models\Training;
use App\Services\Training\TrainingService;

class TrainingController extends BaseController
{
    public function index()
    {
        $trainings = TrainingService::getTrainings();

        return $this->success($trainings->toArray(), 'Formations récupérés avec succès.');
    }

    public function store(TrainingRequest $request)
    {
        $training = TrainingService::createTraining($request->validated());

        return $this->success($training->toArray(), 'Formation créée avec succès.');
    }

    public function show(Training $training)
    {
        $training->load(['teachers', 'categories', 'courses']);

        return $this->success($training->toArray(), 'Formation récupérée avec succès.');
    }

    public function update(TrainingRequest $request, Training $training)
    {
        $training = TrainingService::updateTraining($training, $request->validated());

        return $this->success($training->toArray(), 'Formation mise à jour avec succès.');
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return $this->success([], 'Formation supprimée avec succès.');
    }
}
