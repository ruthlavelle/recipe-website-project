<?php
/**
 * Created by PhpStorm.
 * User: ruthl
 * Date: 07/04/2018
 * Time: 19:34
 */

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class LoadRecipes extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $r1 = new Recipe();
        $r1->setTitle('Lasagne');
        $r1->setSummary('How to make Lasagne');
        $r1->setTags('italian, cheese dishes, pasta');
        $r1->setListOfIngredients('cheese, tomatoe, pasta');
        $r1->setSequenceOfSteps('1. Chop tomatoe, 2. Grate Cheese');

        $r2 = new Recipe();
        $r2->setTitle('Carbonara');
        $r2->setSummary('How to make Carbonara');
        $r2->setTags('italian, cheese dishes, pasta');
        $r2->setListOfIngredients('cheese, tomatoe, pasta');
        $r2->setSequenceOfSteps('1. Chop mushroom');
        
        $manager->persist($r1);
        $manager->persist($r2);

        $manager->flush();
    }
}