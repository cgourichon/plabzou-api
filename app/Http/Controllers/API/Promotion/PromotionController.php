<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\API\BaseController;
use App\Services\Promotion\PromotionService;

class PromotionController extends BaseController
{
    public function index()
    {
        $promotions = PromotionService::getPromotions();

        return $this->success($promotions->toArray(), 'Promotions récupérées avec succès.');
    }
}
