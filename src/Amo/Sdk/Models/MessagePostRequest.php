<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Messages\Message;

class MessagePostRequest extends AbstractModel
{
    public ConversationIdentity $conversationIdentity;
    public Message $message;

    protected array $cast = [
        'conversation_identity' => ConversationIdentity::class,
        'message' => Message::class,
    ];
}