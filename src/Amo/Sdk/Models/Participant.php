<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\IdentityTrait;
use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class Participant extends AbstractModel
{
    protected ?string $userId = null;
    protected ?string $departmentId = null;
    protected ?string $botId = null;
    protected ?string $accessListId = null;

    static public function user(string $id): Participant
    {
        return new Participant([
            'user_id' => $id,
        ]);
    }

    static public function department(string $id): Participant
    {
        return new Participant([
            'department_id' => $id,
        ]);
    }

    static public function bot(string $id): Participant
    {
        return new Participant([
            'department_id' => $id,
        ]);
    }

    static public function accessList(string $id): Participant
    {
        return new Participant([
            'department_id' => $id,
        ]);
    }

    public function getId(): string
    {
        if ($this->userId) {
            return $this->userId;
        }
        if ($this->departmentId) {
            return $this->departmentId;
        }
        if ($this->accessListId) {
            return $this->accessListId;
        }
        if ($this->botId) {
            return $this->botId;
        }
        return '';
    }
}