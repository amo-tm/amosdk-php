<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Bot extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
