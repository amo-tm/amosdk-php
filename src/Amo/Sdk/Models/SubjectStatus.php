<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class SubjectStatus extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;
    protected string $color;
}