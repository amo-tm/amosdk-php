<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class RequestChangeFieldValues extends AbstractModel
{
    protected RequestFieldValue $fieldsValues;

    protected array $cast = [
        'fieldsValues' => RequestFieldValue::class,
    ];
}
