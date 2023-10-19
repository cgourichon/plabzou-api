<?php

namespace App\Http\Controllers\API\Message;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Message\MessageRequest;
use App\Models\Message;
use App\Services\Message\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    /**
     * Permet de créer un nouveau message
     *
     * @param MessageRequest $request
     * @return JsonResponse
     */
    public function store(MessageRequest $request): JsonResponse
    {
        $message = MessageService::createMessage($request->validated());
        return $this->success($message->toArray(), 'Message créé avec succès');
    }

}
