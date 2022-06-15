<?php

namespace Amo\Sdk\Models;

class Currency extends AbstractModel
{
    public const RUB_CODE = 643;

    protected ?int $value = null;
    protected ?int $currency = self::RUB_CODE;

    public function getCurrency(): ?int
    {
        return $this->currency;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }
}
