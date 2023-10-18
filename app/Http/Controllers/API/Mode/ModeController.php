<?php

namespace App\Http\Controllers\API\Mode;

use App\Http\Controllers\API\BaseController;
use App\Services\Learner\LearnerService;

class ModeController extends BaseController
{
    public function index()
    {
        $modes = LearnerService::getLearnerModes();

        return $this->success($modes->toArray(), 'Modes récupérés avec succès.');
    }
}
