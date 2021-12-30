<?php

namespace Amo\Sdk;

use Amo\Sdk\OAuth2\Provider\AmoProvider;
use Amo\Sdk\Service\MessagesService;
use Amo\Sdk\Service\ProfileService;
use Amo\Sdk\Service\TeamService;
use Amo\Sdk\Traits\ServiceInitializer;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\UnifyAudience;
use Lcobucci\JWT\Encoding\UnixTimestampDates;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\RegisteredClaims;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

/**
 * @method MessagesService messages()
 * @method TeamService team(string $teamId = null)
 * @method ProfileService profile(string $profileId = null)
 */
class AmoClient
{
    use ServiceInitializer;
    /**
     *
     */
    public const VERSION_1_3 = 'v1.3';

    /**
     * @var AmoProvider
     */
    protected AmoProvider $provider;

    /**
     * @var AccessToken|mixed|null
     */
    private ?AccessToken $accessToken = null;

    /**
     * @var string
     */
    private string $baseURL = 'https://api.amo.io';
    /**
     * @var string
     */
    private string $authURL = 'https://id.amo.tm';

    /**
     * @var string
     */
    private string $defaultVersion = self::VERSION_1_3;
    /**
     * @var string|mixed
     */
    private string $version;
    /**
     * @var array
     */
    private array $initialOptions;

    /**
     * @var Configuration
     */
    private Configuration $appTokenIssuer;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->initialOptions = $options;
        $this->provider = new AmoProvider($options, $options);
        if (!empty($options['accessToken'])) {
            $this->accessToken = $options['accessToken'];
        }
        if (!empty($options['baseURL'])) {
            $this->baseURL = rtrim($options['baseURL'], '/');
        }
        if (!empty($options['authURL'])) {
            $this->authURL = rtrim($options['authURL'], '/');
        }

        $this->version = $this->defaultVersion;
        if (!empty($options['version'])) {
            $this->version = $options['version'];
        }

        $this->appTokenIssuer = Configuration::forSymmetricSigner(
            new \Lcobucci\JWT\Signer\Hmac\Sha256(),
            InMemory::plainText($this->initialOptions['clientSecret']),
        );
    }

    /**
     * @param array $options
     * @return string
     */
    public function getAuthorizationUrl(array $options = []): string
    {
        return $this->provider->getAuthorizationUrl($options);
    }

    /**
     * @param string $code
     * @param array $options
     * @return AccessToken
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function exchangeCode(string $code, array $options = []): AccessToken
    {
        $options['code'] = $code;
        $this->accessToken = $this->provider->getAccessToken('authorization_code', $options);
        return $this->accessToken;
    }

    /**
     * @param AccessToken $accessToken
     * @return AmoClient
     */
    public function withToken(AccessToken $accessToken): AmoClient
    {
        $sdkClone = clone $this;
        $sdkClone->accessToken = $accessToken;
        return $sdkClone;
    }

    /**
     * @param array $scopes
     * @return AccessToken
     */
    public function getApplicationToken(array $scopes = []): AccessToken
    {
        $now   = new DateTimeImmutable();
        $appToken = $this->appTokenIssuer->builder(new ChainedFormatter(new UnifyAudience(), new UnixTimestampDates()))
            ->identifiedBy(Uuid::uuid4()->toString())
            ->issuedBy($this->initialOptions['clientId'])
            ->permittedFor($this->initialOptions['clientId'])
            ->issuedAt($now)
            ->withClaim('scopes', $scopes)
            ->expiresAt($now->modify('+1 hour'))
            ->getToken($this->appTokenIssuer->signer(), $this->appTokenIssuer->signingKey());

        return new AccessToken(
            [
            'access_token' => $appToken->toString(),
            'expires' => $appToken->claims()->get(RegisteredClaims::EXPIRATION_TIME)->getTimestamp()
            ]
        );
    }

    /**
     * Выдает токен на команду, к которой пользователь дал доступ.
     *
     * @param  string $teamId
     * @return AccessToken
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getTeamAccessToken(string $teamId): AccessToken
    {
        return $this->provider->getAccessToken(
            'exchange_token',
            [
            'team_id' => $teamId,
            'access_token' => $this->accessToken->getToken()
            ]
        );
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeRequest(string $method, string $url, array $options = []): ResponseInterface
    {
        $options = $this->makeOptions($options);
        $request = $this->provider->getAuthenticatedRequest(
            $method,
            $this->makeUrl($url, $options),
            $this->accessToken,
            $options,
        );
        return $this->provider->getHttpClient()->send($request);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $options = []): ResponseInterface
    {
        return $this->makeRequest('POST', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $url, array $options = []): ResponseInterface
    {
        return $this->makeRequest('GET', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $url, array $options = []): ResponseInterface
    {
        return $this->makeRequest('PUT', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $url, array $options = []): ResponseInterface
    {
        return $this->makeRequest('PATCH', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->makeRequest('DELETE', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return string
     */
    private function makeUrl(string $url, array $options = []): string
    {
        if ($options['auth'] ?? null) {
            $baseURL = $this->authURL;
        } else {
            $baseURL = $this->baseURL . '/' . ($options['version'] ?? $this->version);
        }

        return $baseURL . '/' . ltrim($url, '/');
    }

    /**
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    public function me()
    {
        return $this->provider->getResourceOwner($this->accessToken);
    }

    /**
     * @param array $options
     * @return array
     */
    private function makeOptions(array $options): array
    {
        return array_merge(
            [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
            ],
            $options
        );
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }
}
