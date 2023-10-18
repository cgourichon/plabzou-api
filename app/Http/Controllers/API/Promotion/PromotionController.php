<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Promotion\PromotionRequest;
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
}
