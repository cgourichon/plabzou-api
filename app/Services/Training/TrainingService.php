<?php

namespace App\Services\Training;

use App\Models\Training;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrainingService {
    public static function getTrainings(): Collection {
        return Training::with('categories')->get();
    }

    public static function createTraining(array $data): Training {
        DB::beginTransaction();
        try {
            $training = Training::create($data);

            $training->categories()->attach(array_map(fn($category) => $category['id'], $data['categories']));

            $training->courses()->attach(array_map(fn($course) => $course['id'], $data['courses']));

            $training->teachers()->attach(array_map(fn($teacher) => $teacher['id'], $data['teachers']));

            DB::commit();

            return $training;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function updateTraining(Training $training, array $data): Training {
        DB::beginTransaction();
        try {
            $training->update($data);

            $training->categories()->sync(array_map(fn($category) => $category['id'], $data['categories']));

            $training->courses()->sync(array_map(fn($course) => $course['id'], $data['courses']));

            $training->teachers()->sync(array_map(fn($teacher) => $teacher['id'], $data['teachers']));

            DB::commit();

            return $training;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
