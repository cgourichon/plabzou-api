<?php

namespace App\Http\Controllers\API\Course;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Course\CourseRequest;
use App\Models\Course;
use App\Services\Course\CourseService;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = CourseService::getCourses();

        return $this->success($courses->toArray(), 'Cursus récupérés avec succès');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $course = CourseService::createCourse($request->validated());

        return $this->success($course->toArray(), 'Cursus créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return $this->success($course->toArray(), 'Cursus récupéré avec succès');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course = CourseService::updateCourse($course, $request->validated());

        return $this->success($course->toArray(), 'Catégorie mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        CourseService::deleteCourse($course);

        return $this->success([], 'Cursus supprimé avec succès');
    }
}
