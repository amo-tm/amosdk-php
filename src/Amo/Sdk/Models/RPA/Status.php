<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Status extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;
    protected string $color;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }
}
