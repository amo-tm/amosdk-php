<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractCollectionModel;

class RequestFieldsValues extends AbstractCollectionModel
{
    protected int $collectionType = self::COLLECTION_TYPE_MAP;
    protected string $itemClass = RequestFieldValue::class;

    public function getValue(string $fieldId): ?RequestFieldValue {
        return $this[$fieldId];
    }

    public function setValue(string $fieldId, ?RequestFieldValue $value): void {
        $this[$fieldId] = $value;
    }
}
