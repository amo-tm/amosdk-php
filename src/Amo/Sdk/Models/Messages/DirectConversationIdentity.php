<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\Traits\IdentityTrait;

class DirectConversationIdentity implements ConversationIdentityInterface
{
    use IdentityTrait;

    protected string $type = 'direct';
}