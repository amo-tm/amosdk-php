<?php

namespace Amo\Sdk\Exceptions;

class AccessDeniedApiException extends ApiException
{
    public static function invalidSignature(): AccessDeniedApiException {
        return new self("invalid signature", self::ERROR_SIGNATURE_INVALID);
    }

    public static function unsupportedAlgo(): AccessDeniedApiException {
        return new self("unsupported signature algo", self::ERROR_SIGNATURE_UNSUPPORTED_ALGO);
    }

    public static function signatureMismatch(): AccessDeniedApiException {
        return new self("signature mismatch", self::ERROR_SIGNATURE_MISMATCH);
    }
}


