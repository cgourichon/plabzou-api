<?php

namespace App\Services\Message;

use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageService
{
    /**
     * Permet de créer un message
     *
     * @param array $data
     * @return mixed
     */
    public static function createMessage(array $data)
    {
        return Message::create($data);
    }
}
