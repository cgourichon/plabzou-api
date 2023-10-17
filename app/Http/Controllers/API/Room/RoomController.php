<?php

namespace App\Http\Controllers\API\Room;

use App\Http\Controllers\API\BaseController;
use App\Services\Room\RoomService;

class RoomController extends BaseController
{
    public function index()
    {
        $rooms = RoomService::getRooms();

        return $this->success($rooms->toArray(), 'Salles récupérées avec succès.');
    }
}
