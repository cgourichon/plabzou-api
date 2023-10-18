<?php

namespace App\Services\Conversation;

use App\Models\Conversation;
use App\Models\User;
use App\Services\AdministrativeEmployee\AdministrativeEmployeeService;

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

    /**
     * Permet de créer une nouvelle conversation
     *
     * @param array $data
     * @return mixed
     */
    public static function createConversation(array $data)
    {
        $conversation = Conversation::create($data);

        //On ajoute les membres de la conversation
        $adminIds = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        $conversation->members()->sync($adminIds);
        $conversation->members()->attach($data['teacher_id']);

        return $conversation;
    }
}
