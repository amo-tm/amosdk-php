<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Filters\BotsFilter;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\Uuid;

class BotsServiceTest extends TestCase
{
    public function testCreate()
    {
        $teamId = Uuid::uuid4()->toString();
        $container = [];
        $history = Middleware::history($container);

        $featureTeamId = Uuid::uuid4()->toString();
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], '{
  "links": {
    "self": {
      "href": "https://api.amo.io/v1.3/rpa/bots"
    }
  },
  "_embedded": {
    "items": [
      {
        "links": {
          "run": {
            "href": "https://api.amo.io/v1.3/rpa/bots/124bd6f4-7684-11ef-85a0-02420a0001fa/run",
            "method": "POST"
          },
          "self": {
            "href": "https://api.amo.io/v1.3/rpa/bots/b1ea5d32-b41e-11f0-b3e1-02420a000114"
          }
        },
        "id": "124bd6f4-7684-11ef-85a0-02420a0001fa",
        "id": "b1ea5d32-b41e-11f0-b3e1-02420a000114",
        "title": "Заявка на отпуск"
      },
      {
        "links": {
          "run": {
            "href": "https://api.amo.io/v1.3/rpa/bots/c6cba44a-b41e-11f0-b3e1-02420a000114/run",
            "method": "POST"
          },
          "self": {
            "href": "https://api.amo.io/v1.3/rpa/bots/c6cba44a-b41e-11f0-b3e1-02420a000114"
          }
        },
        "id": "dc283ac1-b41e-11f0-b3e1-02420a000114",
        "title": "Заявка на оплату счёта"
      }
    ]
  },
  "count": 2,
  "page_token": "eyJwcm90b3R5cGVfaWRfZ3QiOiJkYzI4M2FjMS1iNDFlLTExZjAtYjNlMS0wMjQyMGEwMDAxMTQifQ=="
}')
        ]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $bots = $sdk->team($teamId)->bots()->get(
            (new BotsFilter())
                ->setLimit(10)
                ->setPageToken("eyJwcm90b3R5cGVfaWRfZ3QiOiJkYzI4M2FjMS1iNDFlLTExZjAtYjNlMS0wMjQyMGEwMDAxMTQifQ==")
                ->setQuery("оплат счёт"),
        );

        $transaction = $container[0];
        /** @var RequestInterface $request */
        $request = $transaction['request'];
        $queryString = $request->getUri()->getQuery();

        self::assertEquals("query=%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%20%D1%81%D1%87%D1%91%D1%82&limit=10&page_token=eyJwcm90b3R5cGVfaWRfZ3QiOiJkYzI4M2FjMS1iNDFlLTExZjAtYjNlMS0wMjQyMGEwMDAxMTQifQ%3D%3D", $queryString);
        self::assertCount(2, $bots->getItems());
        self::assertEquals("eyJwcm90b3R5cGVfaWRfZ3QiOiJkYzI4M2FjMS1iNDFlLTExZjAtYjNlMS0wMjQyMGEwMDAxMTQifQ==", $bots->getPageToken());
    }

    public function testAccessToken()
    {

    }
}
