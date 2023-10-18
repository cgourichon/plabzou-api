<?php

namespace App\Http\Controllers\API\Learner;

use App\Http\Controllers\API\BaseController;
use App\Services\Learner\LearnerService;

class LearnerController extends BaseController
{
    public function index()
    {
        $learners = LearnerService::getLearners();

        return $this->success($learners->toArray(), 'Apprenants récupérés avec succès.');
    }
}
