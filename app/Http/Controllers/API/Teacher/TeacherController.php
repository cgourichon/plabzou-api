<?php

namespace App\Http\Controllers\API\Teacher;

use App\Http\Controllers\API\BaseController;
use App\Services\Teacher\TeacherService;

class TeacherController extends BaseController
{
    public function index()
    {
        $teachers = TeacherService::getTeachers();

        return $this->success($teachers->toArray(), 'Formateurs récupérés avec succès.');
    }
}
