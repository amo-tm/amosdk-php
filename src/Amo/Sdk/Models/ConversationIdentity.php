<?php

namespace Amo\Sdk\Models;

class ConversationIdentity extends AbstractModel
{
    protected ?string $subjectId = null;
    protected ?string $channelId = null;
    protected ?string $directId = null;

    static public function subject(string $subjectId): ConversationIdentity {
        return new ConversationIdentity([
            'subject_id' => $subjectId
        ]);
    }

    static public function channel(string $channelId): ConversationIdentity {
        return new ConversationIdentity([
            'channel_id' => $channelId
        ]);
    }

    static public function direct(string $userId): ConversationIdentity {
        return new ConversationIdentity([
            'direct_id' => $userId
        ]);
    }
}