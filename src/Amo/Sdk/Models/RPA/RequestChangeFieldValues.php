<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class RequestChangeFieldValues extends AbstractModel
{
    protected RequestFieldsValuesCollection $fieldsValues;

    protected array $cast = [
        'fieldsValues' => RequestFieldsValuesCollection::class,
    ];
}
