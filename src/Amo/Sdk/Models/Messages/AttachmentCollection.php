<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractCollectionModel;

class AttachmentCollection extends AbstractCollectionModel
{
    protected string $itemClass = Attachment::class;
}