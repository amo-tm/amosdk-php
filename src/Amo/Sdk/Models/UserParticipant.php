<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\IdentityTrait;

class UserParticipant implements ParticipantInterface
{
    use IdentityTrait;

    protected string $type = 'user';
}
