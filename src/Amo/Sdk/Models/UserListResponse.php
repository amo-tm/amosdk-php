<?php

namespace Amo\Sdk\Models;

class UserListResponse extends AbstractModel
{
    protected int $count;

    protected array $_embedded = [
        "items" => UserCollection::class
    ];

    public function getUsers(): UserCollection {
        return $this->getEmbedded("items");
    }
}
