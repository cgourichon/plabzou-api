<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\API\BaseController;
use App\Services\Request\RequestService;
use Illuminate\Http\JsonResponse;

class RequestController extends BaseController
{
    /**
     * Permet de retrouver la liste des demandes avec les relations associées
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $requests = RequestService::getRequestsWithRelations();
        return $this->success($requests->toArray(), "La liste des demandes a bien été retrouvées");
    }
}
