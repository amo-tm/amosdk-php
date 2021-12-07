<?php

namespace Unit\Amo\Sdk\Models;

use Amo\Sdk\Models\User;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstruct() {
        $p = new User([
            'name' => 'Mike',
            'email' => 'mike@mailforspam.com',
            'team_props' => [
                'is_admin' => true,
                'position' => 'CEO'
            ]
        ]);

        Assert::assertEquals(
            '{"name":"Mike","email":"mike@mailforspam.com","team_props":{"is_admin":true,"position":"CEO"}}',
            (string)$p
        );
    }
}
