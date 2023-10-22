<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Request\RequestRequest;
use App\Models\Request;
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

    /**
     * Permet de créer une nouvelle demande
     *
     * @param RequestRequest $request
     * @return JsonResponse
     */
    public function store(RequestRequest $request): JsonResponse
    {
        try {
            $course = RequestService::createRequest($request->validated());
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        }
        return $this->success($course->toArray(), 'La demande a été créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $requestWithRelation = RequestService::getRequestWithRelation($request);
        return $this->success( $requestWithRelation->toArray(), 'La demande a bien été retrouvée');
    }

    /**
     * Met à jour la requête
     *
     * @param RequestRequest $requestRequest
     * @param Request $request
     * @return JsonResponse
     */
    public function update(RequestRequest $requestRequest, Request $request): JsonResponse
    {
        try {
            $request = RequestService::updateRequest($request, $requestRequest->validated());
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        }
        return $this->success($request->toArray(), 'La demande a bien été mise à jour');
    }

    /**
     * Permet d'annuler une demande (suppression softDelete)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        RequestService::deleteRequest($request);
        return $this->success([], 'La demande a bien été annulée');
    }
}
