<?php

namespace App\Http\Controllers\API\Mode;

use App\Http\Controllers\API\BaseController;
use App\Services\User\UserService;

class ModeController extends BaseController
{
    public function index()
    {
        $modes = UserService::getLearnerModes();

        return $this->success($modes->toArray(), 'Modes récupérés avec succès.');
    }
}
