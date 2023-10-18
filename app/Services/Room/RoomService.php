<?php

namespace App\Services\Room;

use App\Models\Room;
use Illuminate\Support\Collection;

class RoomService
{
    public static function getRooms(): Collection
    {
        return Room::all();
    }
}
