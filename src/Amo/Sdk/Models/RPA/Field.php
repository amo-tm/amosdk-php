<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Field extends AbstractModel
{
    use PrimaryKeyTrait;

    public const TYPE_STRING = 1;
    public const TYPE_TEXT_FIELD = 2;
    public const TYPE_SELECT = 3;
    public const TYPE_MULTISELECT = 3;
    public const TYPE_DATE = 5;
    public const TYPE_DATE_INTERVAL = 5;
    public const TYPE_INT = 8;
    public const TYPE_FLOAT = 9;
    public const TYPE_CURRENCY = 10;
    public const TYPE_DATE_TIME = 7;
    public const TYPE_EMPLOYE = 11;

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
