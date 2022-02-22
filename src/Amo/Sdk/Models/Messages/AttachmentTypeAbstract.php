<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;

class AttachmentTypeAbstract extends AbstractModel
{
    protected string $link;

    public static function create(string $link): self {
        return new static([
            'link' => $link
        ]);
    }
}