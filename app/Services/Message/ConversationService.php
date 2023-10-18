<?php

namespace App\Services\Message;

use App\Models\AdministrativeEmployee;
use App\Models\Message;
use App\Models\User;
use App\Services\AdministrativeEmployee\AdministrativeEmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder;

class ConversationService
{
    /*
    public static function getConversations(User $user): mixed
    {

        $ids = $user->administrativeEmployee()->exists() ? AdministrativeEmployeeService::getAllAdministrativeEmployeeId() : [0 => $user->id];
        Log::info($user->administrativeEmployee()->exists());

        //Si teacher, on groupe sur cet id


        return Message::with(['sender' => function ($query) {
                            $query->select('id', 'last_name', 'first_name');
                        }])
                        ->with(['recipient' => function ($query) {
                            $query->select('id', 'last_name', 'first_name');
                        }])
                        ->whereIn('sender_id' , $ids)
                        ->orWhereIn('recipient_id', $ids)
                        ->latest()
                        ->get();

    }

    public static function getConversation(int $authId): mixed
    {
        $adminIds = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        return Message::where('sender_id', '=', $authId)
                    ->whereIn('recipient_id', $adminIds)
                    ->orWhere('recipient_id', '=', $authId)
                    ->whereIn('sender_id', $adminIds)
                    ->with(['sender' => function ($query) {
                        $query->select('id', 'last_name', 'first_name');
                    }])
                    ->latest()
                    ->get();
    }*/

    public function createConversation()
    {
        //TODO
    }
}
