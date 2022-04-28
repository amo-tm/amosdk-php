<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractCollectionModel;

class RequestChangesCollection extends AbstractCollectionModel
{
    protected string $itemClass = RequestChange::class;
}
