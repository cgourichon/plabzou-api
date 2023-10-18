<?php

namespace App\Http\Controllers\API\Teacher;

use App\Http\Controllers\API\BaseController;
use App\Models\Teacher;
use App\Services\Teacher\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{
    public function index(Request $request)
    {
        $teachers = TeacherService::getTeachers($request->all());

        return $this->success($teachers->toArray(), 'Formateurs récupérés avec succès.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['timeslots.training', 'timeslots.room']);

        return $this->success($teacher->toArray(), 'Formateur récupéré avec succès.');
    }
}
