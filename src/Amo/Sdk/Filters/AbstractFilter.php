<?php

declare(strict_types=1);

namespace Amo\Sdk\Filters;

abstract class AbstractFilter
{
    abstract public function buildFilter(): array;
}
