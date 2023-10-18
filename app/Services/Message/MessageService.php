<?php

namespace App\Services\Message;

use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageService
{
    public static function createMessage(array $data)
    {
        return Message::create($data);
    }
}
