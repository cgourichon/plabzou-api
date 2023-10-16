<?php

namespace App\Http\Controllers\API\Status;

use App\Http\Controllers\API\BaseController;
use App\Services\User\UserService;

class StatusController extends BaseController
{
    public function index()
    {
        $statuses = UserService::getTeacherStatuses();

        return $this->success($statuses, 'Statuts récupérés avec succès.');
    }
}
