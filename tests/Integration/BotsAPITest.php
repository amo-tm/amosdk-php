<?php

namespace Tests\Integration;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\RPA\BotRunParams;
use Amo\Sdk\Service\TeamService;
use League\OAuth2\Client\Token\AccessToken;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class BotsAPITest extends TestCase
{
    protected AmoClient $sdk;
    protected TeamService $teamService;

    protected function setUp(): void
    {
        $this->sdk = new AmoClient([
            'clientId' => getenv('AMO_CLIENT_ID'),
            'clientSecret' => getenv('AMO_CLIENT_SECRET'),
            'authURL' => getenv('AMO_AUTH_URL'),
            'baseURL' => getenv('AMO_BASE_URL'),
        ]);

        $this->teamService = $this->sdk
            ->withToken(new AccessToken(json_decode(getenv('AMO_TEST_TEAM_TOKEN'), true)))
            ->team(getenv('AMO_TEST_TEAM_ID'));
    }

    public function testBotList() {
        $botService = $this->teamService->bots();
        $botList = $botService->get();
        Assert::assertNotEquals(0, $botList->getCount());
        $request = $botService->use($botList->getItems()[0]->getId())->run(new BotRunParams([
            'external_id' => 'leads:213123213',
            'user_id' => '8694a340-b73d-11ec-862e-02420a000132'
        ]));
        Assert::assertEquals($request->getExternalId(), 'leads:213123213');
    }
}
