<?php

namespace App\Http\Controllers\API\Learner;

use App\Http\Controllers\API\BaseController;
use App\Services\User\UserService;

class LearnerController extends BaseController
{
    public function index()
    {
        $learners = UserService::getLearners();

        return $this->success($learners->toArray(), 'Apprenants récupérés avec succès.');
    }
}
