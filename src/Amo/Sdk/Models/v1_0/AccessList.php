<?php

namespace Amo\Sdk\Models\v1_0;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\IdentityTrait;

class AccessList extends AbstractModel
{
    use IdentityTrait;

    public ParticipantCollection $participants;

    protected array $cast = [
        'participants' => ParticipantCollection::class,
    ];
}