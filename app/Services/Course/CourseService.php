<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Support\Collection;

class CourseService
{
    public static function getCourses(): Collection
    {
        return Course::all();
    }

    public static function createCourse(array $data): Course
    {
        return Course::create($data);
    }

    public static function updateCourse(Course $course, array $data): Course
    {
        $course->update($data);

        return $course;
    }

    public static function deleteCourse(Course $course): void
    {
        $course->delete();
    }
}
