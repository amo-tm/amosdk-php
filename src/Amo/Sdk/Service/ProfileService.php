<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\Profile;
use Amo\Sdk\Models\Team;
use League\OAuth2\Client\Token\AccessToken;

class ProfileService extends AbstractService
{
    protected ?string $profileId;

    public function factory(AmoClient $apiClient, string $profileId = null)
    {
        $this->profileId = $profileId;
        $this->apiClient = $apiClient;
    }


    public function create(Profile $profile): Profile
    {
        $resp = $this->apiClient->post(
            $this->profileUrl(),
            [
            'body' => $profile,
            ]
        );
        return Profile::fromStream($resp->getBody());
    }

    private function profileUrl(string $location = ''): string
    {
        $url = '/profiles';
        if ($this->profileId) {
            $url .= '/' . $this->profileId;
        }
        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }
        return $url;
    }
}
