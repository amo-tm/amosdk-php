<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\ConversationIdentity;

class MessageRef extends AbstractModel
{
    protected string $msgId;
    protected ?ConversationIdentity $conversationIdentity;

    public static function create(string $messageId, ?ConversationIdentity $conversationIdentity = null): self {
        return new MessageRef([
            'msg_id' => $messageId,
            'conversation_identity' => $conversationIdentity
        ]);
    }
}
