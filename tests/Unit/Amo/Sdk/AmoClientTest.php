<?php

namespace Tests\Unit\Amo\Sdk;

use Amo\Sdk\AmoClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class AmoClientTest extends TestCase
{
    protected const clientID = 'testClientId';
    protected const clientSecret = 'testClientSecret';

    protected function createClient(?ClientInterface $mockHttpClient = null): AmoClient {
        return new AmoClient([
            'clientId' => self::clientID,
            'clientSecret' => self::clientSecret,
            'httpClient' => $mockHttpClient,
        ]);
    }

    public function testGetAuthorizationUrl()
    {
        $sdk = $this->createClient();

        $authorizationUrl = $sdk->getAuthorizationUrl();

        $parsedUrl = parse_url($authorizationUrl);
        Assert::assertEquals($parsedUrl['scheme'], 'https');
        Assert::assertEquals($parsedUrl['host'], 'id.amo.tm');
        Assert::assertEquals($parsedUrl['path'], '/access');

        $queryParams = [];
        parse_str($parsedUrl['query'], $queryParams);
        Assert::assertEquals($queryParams['client_id'], self::clientID);
    }

    public function testExchangeCode()
    {
        $expectedToken = new AccessToken([
            'token_type' => 'Bearer',
            'expires_in' => 86400,
            'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRkOTMxMmRhMzVjZWY4NmYzOTI3MTZkMTI2Njk4OTc1ZTY5NjZlNjRmOGIxNmU1MjViNTc5ZTE3MDBiN2Q3YWI3N2M1MDU0MTY1YzY5NDI1In0'
        ]);

        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], json_encode($expectedToken->jsonSerialize()))
        ]);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = $this->createClient(new Client(['handler' => $handlerStack]));

        $token = $sdk->exchangeCode('testExchangeCode');
        Assert::assertEquals($expectedToken, $token);

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            echo $request->getBody();
        }
    }

    public function testApplicationToken() {
        $sdk = $this->createClient();
        $appToken = $sdk->getApplicationToken();

        $parsedToken = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(self::clientSecret),
        )->parser()->parse($appToken->getToken());

        self::assertTrue($parsedToken->hasBeenIssuedBy('app'));
        self::assertTrue($parsedToken->isRelatedTo(self::clientID));
    }
}
