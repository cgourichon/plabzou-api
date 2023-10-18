<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\API\BaseController;
use App\Models\City;
use App\Services\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
