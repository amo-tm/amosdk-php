<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class TeamProps extends AbstractModel
{
    use PrimaryKeyTrait;

    protected bool $isAdmin;
    protected ?string $position = null;

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @return string
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }
}