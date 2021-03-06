<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class SubjectThread extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;
    protected string $avatarUrl;

    public function getTitle(): string {
        return $this->title;
    }
}