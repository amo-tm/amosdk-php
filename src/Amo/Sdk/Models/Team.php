<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Team extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param  string $title
     * @return Team
     */
    public function setTitle(string $title): Team
    {
        $this->title = $title;
        return $this;
    }
}
