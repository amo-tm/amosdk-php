<?php

namespace Amo\Sdk\Models\v1_0;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\IdentityTrait;

class Participant extends AbstractModel
{
    use IdentityTrait;

    static public function user($identity): Participant {
        return new Participant([
            'type' => 'user',
            'id' => $identity
        ]);
    }
}