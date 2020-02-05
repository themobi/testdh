<?php

declare(strict_types=1);

namespace App\Domain\User;

use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testDataDraftForUsersIsValidInstance()
    {
        $user = User::draft("Mobi", "mobi@mobi.com", "%f4Hn90hgf");

        $this->assertInstanceOf(
            User::class,
            $user
        );

        $this->assertEquals(
            "Mobi",
            $user->getName()->toValue()
        );
    }
}
