<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    public function testCanCreateUser()
    {
        $user = new User();
        $this->assertNotNull($user);
    }

}
