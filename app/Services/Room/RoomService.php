<?php

namespace App\Services\Room;

use App\Models\Room;
use Illuminate\Support\Collection;

class RoomService
{
    /**
     * Récupérer la liste des salles
     *
     * @return Collection
     */
    public static function getRooms(): Collection
    {
        return Room::all();
    }
}
