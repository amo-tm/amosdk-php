<?php

namespace Amo\Sdk\Models;

class FreeModel extends AbstractModel
{
    protected array $props = [];

    protected function isPropertyExists(string $camelKey): bool
    {
        return true;
    }

    protected function setProperty(string $camelKey, $value)
    {
        return $this->props[$camelKey] = $value;
    }

    protected function getProperties(): array
    {
        return $this->props;
    }
}