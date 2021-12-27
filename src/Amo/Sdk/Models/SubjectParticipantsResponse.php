<?php

namespace Amo\Sdk\Models;

class SubjectParticipantsResponse extends AbstractModel
{
    protected int $count;
    protected int $affected;

    public function getCount(): int {
        return $this->count;
    }

    public function getAffected(): int {
        return $this->affected;
    }
}