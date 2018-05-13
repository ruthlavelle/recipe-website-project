<?php
/**
 * Created by PhpStorm.
 * User: ruthl
 * Date: 31/03/2018
 * Time: 21:48
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"})
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
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="recipe")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return Collection/Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }


    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
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

    public function  setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

