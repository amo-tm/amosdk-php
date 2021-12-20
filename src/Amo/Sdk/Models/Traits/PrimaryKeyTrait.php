<?php

namespace Amo\Sdk\Models\Traits;

trait PrimaryKeyTrait
{
    protected ?string $id = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}