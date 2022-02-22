<?php

namespace Amo\Sdk\Service\v1_0;

use Amo\Sdk\Models\v1_0\AccessList;
use Amo\Sdk\Service\AbstractService;
use Amo\Sdk\Service\TeamService;

class AccessListService extends AbstractService
{
    protected ?string $accessListId;
    protected TeamService $teamService;

    public function factory(TeamService $teamService, string $accessListId = null)
    {
        $this->accessListId = $accessListId;
        $this->teamService = $teamService;
        $this->apiClient = $teamService->apiClient;
    }

    public function create(AccessList $accessList): AccessList
    {
        $resp = $this->teamService->apiClient->post(
            $this->getUrl(),
            [
                'body' => $accessList,
                'version' => 'v1.0'
            ]
        );
        return AccessList::fromStream($resp->getBody());
    }

    /**
     * @return string
     */
    private function getUrl($location = ''): string
    {
        if (is_array($location)) {
            $location = implode('/', $location);
        }

        if (!$this->teamService) {
            throw new \RuntimeException('TeamService not passed. Please, use sdk->team(..)->accessList()');
        }

        $url = '/access_lists';

        if ($this->accessListId) {
            $url .= '/' . $this->accessListId;
        }

        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }

        return $url;
    }
}