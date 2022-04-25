<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractCollectionModel;

class StatusesListCollection extends AbstractCollectionModel
{
    protected string $itemClass = Status::class;

    public function getById(string $statusId): ?Status {
        foreach ($this->items as $value) {
            if ($value->getId() === $statusId) {
                return $value;
            }
        }

        return null;
    }

    public function getValue(string $fieldId): ?Status {
        return $this[$fieldId];
    }

    public function setValue(string $fieldId, ?Status $value): void {
        $this[$fieldId] = $value;
    }
}
