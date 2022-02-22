<?php

namespace Amo\Sdk\Models\v1_0;

use Amo\Sdk\Models\AbstractCollectionModel;

class ParticipantCollection extends AbstractCollectionModel
{
    protected string $itemClass = Participant::class;
}