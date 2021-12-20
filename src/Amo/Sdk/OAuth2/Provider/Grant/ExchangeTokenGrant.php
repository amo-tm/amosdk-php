<?php

namespace Amo\Sdk\OAuth2\Provider\Grant;

use League\OAuth2\Client\Grant\AbstractGrant;

class ExchangeTokenGrant extends AbstractGrant
{
    protected function getName()
    {
        return "exchange_token";
    }

    protected function getRequiredRequestParameters()
    {
        return [
            "team_id",
            "access_token"
        ];
    }
}
