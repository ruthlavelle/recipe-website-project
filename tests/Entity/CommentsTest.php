<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use PHPUnit\Framework\TestCase;


class CommentTest extends TestCase
{
    public function testCanCreateUser()
    {
        $comment = new Comment();
        $this->assertNotNull($comment);
    }

}