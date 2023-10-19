<?php

namespace App\Services\Course;

use App\Models\Course;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CourseService
{
    public static function getCourses(): Collection
    {
        return Course::all();
    }

    /**
     * @throws Exception
     */
    public static function createCourse(array $data): Course
    {
        DB::beginTransaction();
        try {
            $course = Course::create(self::formatCourseData($data));
            $course->trainings()->attach(Collection::make($data['trainings'])->pluck('id'));
            $course->save();
            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function findCourseById(int $id): Course
    {
        return Course::findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public static function updateCourse(Course $course, array $data): Course
    {
        DB::beginTransaction();
        try {
            $course->update(self::formatCourseData($data));
            $course->trainings()->sync(Collection::make($data['trainings'])->pluck('id'));
            $course->save();
            DB::commit();

            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function deleteCourse(Course $course): void
    {
        $course->delete();
    }

    private static function formatCourseData(array $data): array
    {
        return [
            'name' => $data['name'],
        ];
    }
}
