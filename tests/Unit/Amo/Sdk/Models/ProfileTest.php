<?php

namespace Unit\Amo\Sdk\Models;

use Amo\Sdk\Models\Profile;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    public function testConstruct() {
        $p = new Profile([
            'name' => 'Mike',
            'email' => 'mike@mailforspam.com',
            'external_id' => 'vasya1',
            'team_props' => [
                'is_admin' => true,
                'position' => 'CEO'
            ]
        ]);

        Assert::assertEquals('{"external_id":"vasya1","name":"Mike","email":"mike@mailforspam.com","team_props":{"is_admin":true,"position":"CEO"}}', (string)$p);
    }
}
