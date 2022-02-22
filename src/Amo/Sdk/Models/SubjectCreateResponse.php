<?php

namespace Amo\Sdk\Models;

use Psr\Http\Message\StreamInterface;
use Amo\Sdk\Models\SubjectThread;

class SubjectCreateResponse extends Subject
{
    protected array $_embedded = [
        'threads' => SubjectThreadCollection::class
    ];

    public function getThreads(): ?SubjectThreadCollection
    {
        return $this->getEmbedded('threads');
    }
}