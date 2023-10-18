<?php

namespace App\Services\City;

use App\Models\City;
use Illuminate\Support\Collection;

class CityService
{
    public static function getCities(): Collection
    {
        return City::orderBy('postcode')
            ->orderBy('name')
            ->get();
    }

    public static function findCityById(int $id): City
    {
        return City::findOrFail($id);
    }
}
