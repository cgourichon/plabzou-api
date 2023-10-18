<?php

namespace App\Http\Controllers\API\Status;

use App\Http\Controllers\API\BaseController;
use App\Services\Teacher\TeacherService;

class StatusController extends BaseController
{
    public function index()
    {
        $statuses = TeacherService::getTeacherStatuses();

        return $this->success($statuses, 'Statuts récupérés avec succès.');
    }
}
