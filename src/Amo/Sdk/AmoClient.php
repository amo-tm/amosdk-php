<?php

namespace Amo\Sdk;

use Amo\Sdk\OAuth2\Provider\AmoProvider;
use Amo\Sdk\Service\MessagesService;
use Amo\Sdk\Service\ProfileService;
use Amo\Sdk\Service\TeamService;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\MicrosecondBasedDateConversion;
use Lcobucci\JWT\Encoding\UnifyAudience;
use Lcobucci\JWT\Encoding\UnixTimestampDates;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
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
    public const VERSION_1_3 = 'v1.3';

    protected AmoProvider $provider;

    private ?AccessToken $accessToken = null;

    private string $baseURL = 'https://api.amo.io';
    private string $authURL = 'https://id.amo.tm';

    private string $defaultVersion = self::VERSION_1_3;
    private string $version;
    private array $initialOptions;

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

    public function getAuthorizationUrl(array $options = []): string {
        return $this->provider->getAuthorizationUrl($options);
    }

    public function exchangeCode(string $code, array $options = []): AccessToken {
        $options['code'] = $code;
        $this->accessToken = $this->provider->getAccessToken('authorization_code', $options);
        return $this->accessToken;
    }

    public function withToken(AccessToken $accessToken): AmoClient {
        $sdkClone = clone $this;
        $sdkClone->accessToken = $accessToken;
        return $sdkClone;
    }

    public function getApplicationToken(array $scopes = []): AccessToken {
        $now   = new DateTimeImmutable();
        $appToken = $this->appTokenIssuer->builder(new ChainedFormatter(new UnifyAudience(), new UnixTimestampDates()))
            ->identifiedBy(Uuid::uuid4()->toString())
            ->issuedBy($this->initialOptions['clientId'])
            ->permittedFor($this->initialOptions['clientId'])
            ->issuedAt($now)
            ->withClaim('scopes', $scopes)
            ->expiresAt($now->modify('+1 hour'))
            ->getToken($this->appTokenIssuer->signer(), $this->appTokenIssuer->signingKey());

        return new AccessToken([
            'access_token' => $appToken->toString(),
            'expires' => $appToken->claims()->get(RegisteredClaims::EXPIRATION_TIME)->getTimestamp()
        ]);
    }

    /**
     * Выдает токен на команду, к которой пользователь дал доступ.
     * @param string $teamId
     * @return AccessToken
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getTeamAccessToken(string $teamId): AccessToken
    {
        return $this->provider->getAccessToken('exchange_token', [
            'team_id' => $teamId,
            'access_token' => $this->accessToken->getToken()
        ]);
    }

    public function makeRequest(string $method, string $url, array $options = []): ResponseInterface {
        $options = $this->makeOptions($options);
        $request = $this->provider->getAuthenticatedRequest(
            $method,
            $this->makeUrl($url, $options),
            $this->accessToken,
            $options,
        );
        return $this->provider->getHttpClient()->send($request);
    }

    public function post(string $url, array $options = []): ResponseInterface {
        return $this->makeRequest('POST', $url, $options);
    }

    public function get(string $url, array $options = []): ResponseInterface {
        return $this->makeRequest('GET', $url, $options);
    }

    public function put(string $url, array $options = []): ResponseInterface {
        return $this->makeRequest('PUT', $url, $options);
    }

    public function patch(string $url, array $options = []): ResponseInterface {
        return $this->makeRequest('PATCH', $url, $options);
    }

    public function delete(string $url, array $options = []): ResponseInterface {
        return $this->makeRequest('DELETE', $url, $options);
    }

    private function makeUrl(string $url, array $options = []): string
    {
        if ($options['auth'] ?? null) {
            $baseURL = $this->authURL;
        } else {
            $baseURL = $this->baseURL . '/' . ($options['version'] ?? $this->version);
        }

        return $baseURL . '/' . ltrim($url, '/');
    }

    public function __call($method, $arguments)
    {
        $serviceClassName = '\\Amo\\Sdk\\Service\\' . ucfirst($method) . 'Service';
        if (!class_exists($serviceClassName)) {
            throw new \BadMethodCallException(
                'Call to undefined method ' . get_class($this) . '::' . $method . '()'
            );
        }

        return call_user_func_array([new $serviceClassName, '__invoke'], array_merge([$this], $arguments));
    }

    public function me() {
        return $this->provider->getResourceOwner($this->accessToken);
    }

    private function makeOptions(array $options): array
    {
        return array_merge([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ], $options);
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }
}