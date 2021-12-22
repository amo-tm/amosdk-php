<?php

namespace Amo\Sdk\Models;

use Psr\Http\Message\StreamInterface;

class SubjectCreateResponse extends Subject
{
    protected ?EmbeddedSubject $_embedded;

    public function getEmbedded(): EmbeddedSubject
    {
        return $this->_embedded;
    }
}