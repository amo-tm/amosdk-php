<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractCollectionModel;

class BotListCollection extends AbstractCollectionModel
{
    protected string $itemClass = Bot::class;
}
