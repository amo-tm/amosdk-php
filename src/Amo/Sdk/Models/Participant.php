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
    protected ?string $threadId = null;

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
            'bot_id' => $id,
        ]);
    }

    static public function accessList(string $id): Participant
    {
        return new Participant([
            'access_list_id' => $id,
        ]);
    }

    static public function thread(string $id): Participant
    {
        return new Participant([
            'thread_id' => $id,
        ]);
    }

    public function getId(): ?string
    {
        if ($this->userId) {
            return $this->userId;
        } else if ($this->departmentId) {
            return $this->departmentId;
        } else if ($this->accessListId) {
            return $this->accessListId;
        } else if ($this->botId) {
            return $this->botId;
        } else if ($this->threadId) {
            return $this->threadId;
        }
        return null;
    }

    public function isAll(): bool {
        return is_null($this->getId());
    }
}
