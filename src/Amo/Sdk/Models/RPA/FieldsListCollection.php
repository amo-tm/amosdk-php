<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractCollectionModel;

class FieldsListCollection extends AbstractCollectionModel
{
    protected string $itemClass = Field::class;

    public function getById(string $fieldId): ?Field {
        foreach ($this->items as $value) {
            if ($value->getId() === $fieldId) {
                return $value;
            }
        }

        return null;
    }
    public function getValue(string $fieldId): ?Field {
        return $this[$fieldId];
    }

    public function setValue(string $fieldId, ?Field $value): void {
        $this[$fieldId] = $value;
    }
}
