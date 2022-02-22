<?php

namespace Amo\Sdk\Models;

use Psr\Http\Message\StreamInterface;
use Amo\Sdk\Models\SubjectThread;

class SubjectCreateRequest extends Subject
{
    public ?SubjectThreadCollection $threads;
}