<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Promotion\PromotionRequest;
use App\Models\Promotion;
use App\Services\Promotion\PromotionService;
use Illuminate\Http\JsonResponse;

class PromotionController extends BaseController
{
    public function index()
    {
        $promotions = PromotionService::getPromotions();

        return $this->success($promotions->toArray(), 'Promotions récupérées avec succès.');
    }

    /**
     * @throws \Exception
     */
    public function store(PromotionRequest $request): JsonResponse
    {
        $promotion = PromotionService::createPromotion($request->validated());

        return $this->success($promotion->toArray(), 'Promotion créée avec succès.');
    }

    public function show(Promotion $promotion): JsonResponse
    {
        $promotion->load('learners');

        return $this->success($promotion->toArray(), 'Promotion récupérée avec succès.');
    }

    public function update(PromotionRequest $request, Promotion $promotion): JsonResponse
    {
        $promotion = PromotionService::updatePromotion($promotion, $request->validated());
        return $this->success($promotion->toArray(), 'Promotion mise à jour avec succès.');
    }
}
