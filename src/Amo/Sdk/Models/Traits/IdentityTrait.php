<?php

namespace Amo\Sdk\Models\Traits;

trait IdentityTrait
{
    use PrimaryKeyTrait;

    protected ?string $type = '';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


}