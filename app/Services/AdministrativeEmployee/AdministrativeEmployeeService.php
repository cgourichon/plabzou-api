<?php

namespace App\Services\AdministrativeEmployee;

use App\Models\AdministrativeEmployee;
use App\Models\Message;
use Illuminate\Support\Collection;

class AdministrativeEmployeeService
{

    /*
    public static function getAllAdministrativeEmployeeMessage()
    {
        $ids = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        return Message::whereIn('sender_id', $ids)
                        ->orWhereIn('recipient_id', $ids)
                        ->get();
    }

       */
    public static function getAllAdministrativeEmployeeId(): Collection
    {
        return AdministrativeEmployee::all()->pluck('user_id');
    }

}
