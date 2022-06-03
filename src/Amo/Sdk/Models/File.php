<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\IdentityTrait;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class File extends AbstractModel
{
    protected string $fileName;
    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
