<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Exceptions\AccessDeniedApiException;
use Amo\Sdk\Models\SheetContext;
use Amo\Sdk\Models\Webhook\Webhook;
use Psr\Http\Message\RequestInterface;

class SheetsService extends AbstractService
{
    public function factory(AmoClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @throws AccessDeniedApiException
     */
    public function process(RequestInterface $request): SheetContext {
        $requestBody = (string)$request->getBody();
        parse_str($requestBody, $requestParsedBody);
        $signature = $requestParsedBody['signature'] ?? null;
        if (!$signature) {
            throw AccessDeniedApiException::invalidSignature();
        }

        $requestFilteredBody = [];
        foreach ($requestParsedBody as $k => $v) {
            switch ($k) {
                case 'context_company_id':
                    $k = 'context.company_id';
                    break;
                case 'context_user_id':
                    $k = 'context.user_id';
                    break;
                case 'signature':
                    continue 2;
                case 'input_values':
                    $requestFilteredBody = array_merge($requestFilteredBody, $this->buildFlatArray($v, 'input_values'));
                    continue 2;
            }
            $requestFilteredBody[$k] = $v;
        }

        ksort($requestFilteredBody);
        $requestFilteredBodyString = '';
        foreach ($requestFilteredBody as $k => $v) {
            $requestFilteredBodyString .= ($k . $v);
        }
        list($algo, $hash) = explode('=', $signature);
        if (!function_exists($algo)) {
            throw AccessDeniedApiException::unsupportedAlgo();
        }

        $computedHash = hash_hmac($algo, $requestFilteredBodyString, $this->apiClient->getClientSecret());
        if ($computedHash !== $hash) {
            throw AccessDeniedApiException::invalidSignature();
        }

        return new SheetContext([
            'company_id' => $requestParsedBody['context_company_id'],
            'user_id' => $requestParsedBody['context_user_id'],
            'widget_id' => $requestParsedBody['widget_id'],
            'input_values' => $requestParsedBody['input_values'],
        ]);
    }

    protected function buildFlatArray(array $a, $prefix = ''): array {
        $returnArray = [];
        foreach ($a as $k => $v) {
            if (is_array($v)) {
                foreach ($this->buildFlatArray($v, $k) as $k2 => $v2) {
                    $realPrefix = $prefix;
                    if ($realPrefix) {
                        $realPrefix .= '['.$k2.']';
                    } else {
                        $realPrefix = $k2;
                    }
                    $returnArray[$realPrefix] = $v2;
                }
            } else {
                $realPrefix = $prefix;
                if ($realPrefix) {
                    $realPrefix .= '['.$k.']';
                } else {
                    $realPrefix = $k;
                }
                $returnArray[$realPrefix] = $v;
            }
        }
        return $returnArray;
    }
}
