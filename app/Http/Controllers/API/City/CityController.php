<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\City\CityRequest;
use App\Models\City;
use App\Services\City\CityService;
use Illuminate\Http\JsonResponse;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $cities = CityService::getCities();

        return $this->success($cities->toArray(), 'Villes récupérées avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $city = CityService::createCity($request->validated());

        return $this->success($city->toArray(), 'Ville créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return $this->success($city->toArray(), 'Ville récupérée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        $city = CityService::updateCity($city, $request->validated());

        return $this->success($city->toArray(), 'Ville mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();

        return $this->success([], 'Ville supprimée avec succès.');
    }
}
