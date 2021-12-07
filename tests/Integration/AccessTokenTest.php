<?php

namespace Tests\Integration;

use Amo\Sdk\AmoClient;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function testAppToken()
    {
        $sdk = new AmoClient([
            'clientId' => getenv('AMO_CLIENT_ID'),
            'clientSecret' => getenv('AMO_CLIENT_SECRET'),
            'authURL' => getenv('AMO_AUTH_URL'),
            'baseURL' => getenv('AMO_BASE_URL'),
        ]);

        $appScopedSdk = $sdk->withToken($sdk->getApplicationToken(['teams', 'profiles']));
        $teamToken = $appScopedSdk->getTeamAccessToken('ff019cfa-574a-11ec-8dde-02420a0001ef');
        print_r($teamToken);

        $this->expectNotToPerformAssertions();
    }

    public function testAuthorizationURlGenerate()
    {
        $sdk = new AmoClient([
            'clientId' => getenv('AMO_CLIENT_ID'),
            'clientSecret' => getenv('AMO_CLIENT_SECRET'),
        ]);

        $authorizationUrl = $sdk->getAuthorizationUrl([
            'company_id' => '1118f3fe-fdb7-11eb-b43e-00163ef260f3',
            'scope' => 'bot:w'
        ]);

        echo $authorizationUrl;
    }

    public function testExchangeCode()
    {
        $sdk = new AmoClient([
            'clientId' => getenv('AMO_CLIENT_ID'),
            'clientSecret' => getenv('AMO_CLIENT_SECRET'),
        ]);

        $token = $sdk->exchangeCode('def5020081ec603c9258a1bb4cb66af65688617c8353ddcbd5e4f7a289884d877ceaea63affa3777c919bad5621b076f2a0e07707676b016604949c0ee3624d83b1c707e324839c9171d133bc1c7c19f3a0d96badf14ebd1f3e77c383315cecb320af0cb0de0486057a247d06608afa7d0bd1c47e927c7b9370030e11dbbba00f280655d625bbc8900534764ffe19f402aaa6375417e8effcc4986655d7a7d57c6db0f173129e2b454c1cc507c24f551dffd9c5ff8a84106c0b768c058cc3bab1ea2f67063c87541147d00e7a070d24657eaf38e04e69f5eee62412f99afe07b54103e5fdfe2815b838fd8b42605a80f7c7355e1ac59e1c51fb481cdeba90da7d27d846e529db54938838bc550174df82c5a343067d83029fd93cc5d857ed6d08ac1c3a598a576d224908da33c0c74565ecbcbfb98818da9fcf9b5b0c6ec39f9d2e015521d7eecc6e2b1dbc980354fa17485f324e3883995d0dca7045bca55c114e9f340017e48e1c5038b9476c5bdfcadc48076c46abe9b8243f0e380f3e18e0425be95cf31f93b1a45d5529b10f75c9cfab94f7368d618c678b3017a14ca9cc02ef39dbf3f69c8301433e7cc6075cf6899642aa47fb771e8dc5c6b09d62ba13c4a33e579858a');
        print_r($token);
    }
}