<?php

namespace App\Http\Controllers\API\Learner;

use App\Http\Controllers\API\BaseController;
use App\Models\Learner;
use App\Services\Learner\LearnerService;
use Illuminate\Http\Request;

class LearnerController extends BaseController
{
    public function index(Request $request)
    {
        $learners = LearnerService::getLearners($request->all());

        return $this->success($learners->toArray(), 'Apprenants récupérés avec succès.');
    }

    public function show(Learner $learner)
    {
        $learner->load([
            'timeslots.training.courses.promotions',
            'timeslots.training.categories',
            'timeslots.learners',
            'timeslots.teachers',
            'timeslots.room.building.place.city'
        ]);

        return $this->success($learner->toArray(), 'Apprenant récupéré avec succès.');
    }
}
