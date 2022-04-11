<?php

namespace Amo\Sdk\Exceptions;

class ApiException extends RuntimeException
{
    const ERROR_SIGNATURE_INVALID = 1000;
    const ERROR_SIGNATURE_UNSUPPORTED_ALGO = 1001;
    const ERROR_SIGNATURE_MISMATCH = 1002;
}
