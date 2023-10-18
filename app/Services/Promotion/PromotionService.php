<?php

namespace App\Services\Promotion;

use App\Models\City;
use App\Models\Course;
use App\Models\Promotion;
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
            $promotion->course()->associate(Course::findOrFail($data['course']));

            $promotion->course()->associate(Course::findOrFail($data['course']));
            if ($data['city']) {
                $promotion->city()->associate(City::findOrFail($data['city']));
            }

            $promotion->learners()->attach(Collection::make($data['learners'])->pluck('user_id'));
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
