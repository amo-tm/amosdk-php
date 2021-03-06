<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\Models\MessagePostRequest;
use Amo\Sdk\Models\Messages\Message;

class MessagesService extends AbstractService
{
    protected ?string $messageId;
    protected TeamService $teamService;

    public function factory(TeamService $teamService)
    {
        $this->teamService = $teamService;
        $this->apiClient = $teamService->apiClient;
    }

    public function send(MessagePostRequest $messagePostRequest): Message {
        $resp = $this->teamService->apiClient->post(
            $this->getUrl(),
            [
                'body' => $messagePostRequest,
            ]
        );
        return Message::fromStream($resp->getBody());
    }

    private function getUrl($location = ''): string
    {
        if (is_array($location)) {
            $location = implode('/', $location);
        }

        if (!$this->teamService) {
            throw new \RuntimeException('TeamService not passed. Please, use sdk->team(..)->accessList()');
        }

        $url = '/messages';

        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }

        return $url;
    }
}