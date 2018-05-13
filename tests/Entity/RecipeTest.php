<?php

namespace App\Tests\Entity;

use App\Entity\Recipe;
use PHPUnit\Framework\TestCase;


class RecipeTest extends TestCase
{
    public function testCanCreateRecipe()
    {
        $recipe = new Recipe();
        $this->assertNotNull($recipe);
    }

}