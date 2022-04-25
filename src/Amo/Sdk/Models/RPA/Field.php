<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Field extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;
    protected string $type;

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
    public function getType(): string
    {
        return $this->type;
    }
}
