<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\Team;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TeamServiceTest extends TestCase
{
    public function testCreate()
    {
        $container = [];
        $history = Middleware::history($container);

        $featureTeamId = Uuid::uuid4()->toString();
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], json_encode([
                'id' => $featureTeamId,
                'name' => 'СуперТим'
            ]))
        ]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $createdTeam = $sdk->team()->create(new Team([
            'name' => 'СуперТим',
        ]));

        self::assertEquals($featureTeamId, $createdTeam->getId());
    }

    public function testAccessToken()
    {

    }
}
