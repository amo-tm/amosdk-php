<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\Models\FreeModel;
use Amo\Sdk\Models\MarkupProcessRequest;
use Amo\Sdk\Models\MarkupProcessResponse;
use Amo\Sdk\Models\Messages\MessageCollection;
use Amo\Sdk\Models\Messages\MessageSearchResponse;
use Amo\Sdk\Models\RPA\Bot;
use Amo\Sdk\Models\RPA\BotListResponse;
use Amo\Sdk\Models\RPA\BotReturnControlRequest;
use Amo\Sdk\Models\RPA\BotRunParams;
use Amo\Sdk\Models\RPA\Request;

class BotsService extends AbstractService
{
    const REQUEST_SEARCH_DEFAULT_LIMIT = 50;
    public const REQUEST_SEARCH_TYPE_PHOTO = 1;
    public const REQUEST_SEARCH_TYPE_DOCUMENT = 2;
    public const REQUEST_SEARCH_TYPE_VIDEO = 3;
    public const REQUEST_SEARCH_TYPE_VOICE = 4;

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

    private function getRequestUrl(string $requestId, $location = null, $args = []): string
    {
        return $this->getUrl(array_merge(
            ['request', $requestId],
            (array)$location
        ), $args);
    }

    private function getUrl($location = null, $args = []): string
    {
        $location = implode('/', (array)$location);

        $url = '/bots';
        if ($this->botId) {
            $url .= '/' . $this->botId;
        }

        if ($location) {
            $url .= '/' . ltrim($location, '/');
        }

        if (count($args) > 0) {
            $url .= '?' . preg_replace(
                '/(%5B)\d+(%5D=)/i',
                '$1$2',
                http_build_query($args, "", null, PHP_QUERY_RFC3986)
            );
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

    public function processMarkup(string $requestID, MarkupProcessRequest $request): MarkupProcessResponse {
        $response = $this->apiClient->post(
            $this->getRequestUrl($requestID, 'processMarkup'),
            [
                'body' => $request
            ]
        );
        return MarkupProcessResponse::fromStream($response->getBody());
    }

    public function getRequest(string $id): Request {
        $response = $this->apiClient->get($this->getRequestUrl($id));

        return Request::fromStream($response->getBody());
    }

    public function requestSearch(string $requestId, array $options = []): MessageSearchResponse {
        $args = [];
        foreach ($options['type'] ?? [] as $type) {
            $args['filter']['type'][] = $type;
        }
        $args['page']['limit'] = $options['page_limit'] ?? self::REQUEST_SEARCH_DEFAULT_LIMIT;

        if (!empty($options['page_token'])) {
            $args['page']['token'] = $options['page_token'];
        }

        $response = $this->apiClient->get(
            $this->getRequestUrl($requestId, 'search', $args),
        );

        return MessageSearchResponse::fromStream($response->getBody());
    }

    public function get(): BotListResponse {
        $response = $this->apiClient->get(
            $this->getUrl(),
        );
        return BotListResponse::fromStream($response->getBody());
    }

    public function byId($botid): Bot {
        $response = $this->apiClient->get(
            $this->getUrl($botid),
        );
        return Bot::fromStream($response->getBody());
    }

    public function run(BotRunParams $runParams): Request {
        $response = $this->apiClient->post(
            $this->getUrl('run'),
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
