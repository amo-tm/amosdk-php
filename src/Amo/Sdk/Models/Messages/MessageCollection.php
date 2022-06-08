<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractCollectionModel;

class MessageCollection extends AbstractCollectionModel
{
    protected string $itemClass = Message::class;
}
