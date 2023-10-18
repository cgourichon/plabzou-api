<?php

namespace App\Services\Promotion;

use App\Models\City;
use App\Models\Course;
use App\Models\Promotion;
use App\Services\City\CityService;
use App\Services\Course\CourseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    public static function getPromotions(): Collection
    {
        return Promotion::with(['course', 'learners', 'city'])
            ->orderByDesc('starts_at')
            ->orderByDesc('ends_at')
            ->get();
    }

    /**
     * @throws \Exception
     */
    public static function createPromotion(array $data): Promotion
    {
        DB::beginTransaction();
        try {
            $promotion = Promotion::create(self::formatPromotionData($data));

            $course = CourseService::findCourseById($data['course']);
            $promotion->course()->associate($course);

            if ($data['city']) {
                $city = CityService::findCityById($data['city']);
                $promotion->city()->associate($city);
            }
            if($data['learners']) {
                $promotion->learners()->attach(Collection::make($data['learners'])->pluck('user_id'));
            }
            $promotion->save();
            DB::commit();

            return $promotion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public static function updatePromotion(Promotion $promotion, array $data): Promotion
    {
        DB::beginTransaction();
        try {
            $promotion = $promotion->fill(self::formatPromotionData($data));

            $course = CourseService::findCourseById($data['course']);
            if($promotion->course <> $course) {
                $promotion->course()->dissociate();
                $promotion->course()->associate($course);
            }

            if ($data['city']) {
                $city = CityService::findCityById($data['city']);
                if($promotion->city <> $city) {
                    $promotion->city()->dissociate();
                }
                $promotion->city()->associate($city);
            } else {
                $promotion->city()->dissociate();
            }

            if($data['learners']) {
                $promotion->learners()->sync(Collection::make($data['learners'])->pluck('user_id'));
            } else {
                $promotion->learners()->detach();
            }
            $promotion->save();
            DB::commit();

            return $promotion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private static function formatPromotionData(array $data): array
    {
        $formattedData = [
            'name' => $data['name'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'course_id' => $data['course'],
        ];

        if($data['city']) $formattedData['city_id'] = $data['city'];

        return $formattedData;
    }
}
