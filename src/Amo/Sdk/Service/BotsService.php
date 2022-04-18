<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\Models\RPA\BotListResponse;
use Amo\Sdk\Models\RPA\BotReturnControlRequest;
use Amo\Sdk\Models\RPA\BotRunParams;
use Amo\Sdk\Models\RPA\Request;

class BotsService extends AbstractService
{
    protected TeamService $teamService;
    protected ?string $botId = null;

    public function factory(TeamService $teamService, ?string $botId = null)
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
        return $this->getUrl(array_merge(
            ['request', $requestId],
            (array)$location)
        );
    }

    private function getUrl($location = ''): string
    {
        if (is_array($location)) {
            $location = implode('/', $location);
        }

        $url = '/bots';
        if ($this->botId) {
            $url .= '/' . $this->botId;
        }

        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }

        return $url;
    }

    public function updateRequest(Request $request): Request {
        $response = $this->apiClient->put(
            $this->getRequestUrl($request->getId()),
            [
                'body' => $request
            ]
        );
        return Request::fromStream($response->getBody());
    }

    public function get(): BotListResponse {
        $response = $this->apiClient->get(
            $this->getUrl(),
        );
        return BotListResponse::fromStream($response->getBody());
    }

    public function run(BotRunParams $runParams): Request {
        $response = $this->apiClient->post(
            $this->getUrl(),
            [
                'body' => $runParams
            ]
        );
        return Request::fromStream($response->getBody());
    }

    public function use(string $botId): BotsService {
        if ($this->botId === $botId) {
            return $this;
        }
        $botService = clone $this;
        $botService->botId = $botId;
        return $botService;
    }
}
