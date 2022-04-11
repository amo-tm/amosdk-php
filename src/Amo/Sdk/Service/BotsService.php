<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\Models\RPA\BotReturnControlRequest;

class BotsService extends AbstractService
{
    protected TeamService $teamService;
    protected string $botId;

    public function factory(TeamService $teamService, string $botId)
    {
        $this->teamService = $teamService;
        $this->apiClient = $teamService->apiClient;
        $this->botId = $botId;
    }

    public function returnControl(string $requestId, string $statusCode) {
        $this->apiClient->post(
            $this->getRequestUrl($requestId, 'returnControl'),
            [
                'body' => new BotReturnControlRequest([
                    'return_code' => $statusCode
                ])
            ]
        );
    }

    private function getRequestUrl(string $requestId, $location = ''): string
    {
        if (is_array($location)) {
            $location = implode('/', $location);
        }

        $url = '/bots/' . $this->botId . '/request/' . $requestId;

        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }

        return $url;
    }
}
