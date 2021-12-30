<?php

namespace Amo\Sdk\Models;

use Psr\Http\Message\StreamInterface;
use Amo\Sdk\Models\SubjectThread;

class SubjectCreateResponse extends Subject
{
    protected ?array $embedded = array();
    protected ?array $threadArray = array();

    public function getThreads(): array
    {
        if (!empty($this->threadArray)) {
            return $this->threadArray;
        }

        if ((array_key_exists("threads", $this->embedded))
            and (array_key_exists("_embedded", $this->embedded["threads"]))
            and (array_key_exists("threads", $this->embedded["threads"]["_embedded"]))
        ) {
            $threads =  array();
            foreach ($this->embedded["threads"]["_embedded"]["threads"] as $thread) {
                array_push($threads, new SubjectThread([
                    "title" => $thread["_embedded"]["thread"]["title"],
                    "id" => $thread["_embedded"]["thread"]["id"]
                ]));
//                print $thread["_embedded"]["thread"]["title"]."\n";
            }
            $this->threadArray = $threads;
            return $threads;
        }
        return array();
    }
}