<?php
/**
 * Created by PhpStorm.
 * User: ruthl
 * Date: 31/03/2018
 * Time: 21:48
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */


class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $summary;

    /**
     * @ORM\Column(type="string")
     */
    private $tags;

    /**
     * @ORM\Column(type="string")
     */
    private $listOfIngredients;

    /**
     * @ORM\Column(type="string")
     */
    private $sequenceOfSteps;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recipes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getListOfIngredients()
    {
        return $this->listOfIngredients;
    }

    public function setListOfIngredients($listOfIngredients)
    {
        $this->listOfIngredients = $listOfIngredients;
    }

    public function getSequenceOfSteps()
    {
        return $this->sequenceOfSteps;
    }

    public function setSequenceOfSteps($sequenceOfSteps)
    {
        $this->sequenceOfSteps = $sequenceOfSteps;
    }

    public function getUser(): ?User
    {
       return $this->user;
    }

    public function  setUser($user = null)
    {
        $this->user = $user;
    }
}

