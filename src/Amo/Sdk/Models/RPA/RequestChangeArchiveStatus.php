<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class RequestChangeArchiveStatus extends AbstractModel
{
    protected bool $isArchived;

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }
}
