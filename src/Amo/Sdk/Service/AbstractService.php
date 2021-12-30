<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Service\Interfaces\ServiceInterface;

use function Symfony\Component\Translation\t;

abstract class AbstractService implements ServiceInterface
{
    protected AmoClient $apiClient;
}
