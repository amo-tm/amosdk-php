<?php

namespace Amo\Sdk\Models;

class ConversationIdentity extends AbstractModel
{
    protected ?string $subjectId = null;

    static public function subject(string $subjectId): ConversationIdentity {
        return new ConversationIdentity([
            'subject_id' => $subjectId
        ]);
    }
}