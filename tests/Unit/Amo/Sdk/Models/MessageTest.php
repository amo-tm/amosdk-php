<?php

namespace Unit\Amo\Sdk\Models;

use Amo\Sdk\Models\Messages\Message;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{

    public function test__toString()
    {
        $message = new Message([
            'text' => 'test text',
        ]);

        self::assertEquals('{"text":"test text"}', (string)$message);
        self::assertEquals('{"text":"test text"}', Message::fromStream(Utils::streamFor('{"text":"test text"}')));
    }
}
