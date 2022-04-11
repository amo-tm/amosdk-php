<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Exceptions\AccessDeniedApiException;
use Amo\Sdk\Models\Webhook\Webhook;
use Psr\Http\Message\RequestInterface;

class WebhookService extends AbstractService
{
    public function factory(AmoClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @throws AccessDeniedApiException
     */
    public function process(RequestInterface $request): Webhook {
        $signature = $request->getHeaderLine('x-signature');
        if (!$signature) {
            throw AccessDeniedApiException::invalidSignature();
        }

        list($algo, $hash) = explode('=', $signature);
        if (!function_exists($algo)) {
            throw AccessDeniedApiException::unsupportedAlgo();
        }

        $requestBody = $request->getBody();

        $computedHash = hash_hmac($algo, (string)$requestBody, $this->apiClient->getClientSecret());
        if ($computedHash !== $hash) {
            throw AccessDeniedApiException::invalidSignature();
        }

        $requestBody->rewind();

        return Webhook::fromStream($requestBody);
    }
}
