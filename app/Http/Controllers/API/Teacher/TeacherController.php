<?php

namespace App\Http\Controllers\API\Teacher;

use App\Http\Controllers\API\BaseController;
use App\Services\User\UserService;

class TeacherController extends BaseController
{
    public function index()
    {
        $teachers = UserService::getTeachers();

        return $this->success($teachers->toArray(), 'Formateurs récupérés avec succès.');
    }
}
