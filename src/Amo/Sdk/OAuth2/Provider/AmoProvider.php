<?php

namespace Amo\Sdk\OAuth2\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class AmoProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    protected const BASE_AMO_ID_URL = 'https://id.amo.tm';
    protected string $authURL;

    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
        $this->authURL = $options['authURL'] ?? self::BASE_AMO_ID_URL;
        $this->getGrantFactory()->setGrant("exchange_token", new Grant\ExchangeTokenGrant());
    }

    public function getBaseAuthorizationUrl(): string
    {
        return $this->getBaseAmoIDUrl() . '/access';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->getBaseAmoIDUrl() . '/oauth2/access_token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getBaseAmoIDUrl() . '/oauth2/validate';
    }

    protected function getDefaultScopes(): array
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        // TODO: Implement checkResponse() method.
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        print_r($response);
        die();
    }

    protected function getBaseAmoIDUrl(): string
    {
        return $this->authURL;
    }
}
