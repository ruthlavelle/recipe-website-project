<?php

namespace App\Form;

use App\Entity\Recipe;
use Doctrine\ORM\Mapping\Entity;
use Faker\Provider\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', TextType::class)
            ->add('title', TextType::class)
            ->add('summary', TextType::class)
            ->add('tags', TextType::class)
            ->add('listOfIngredients', TextType::class)
            ->add('sequenceOfSteps', TextType::class)
            ->add('user', EntityType::class, [
                'class' => 'App:User' ,
                'choice_label' => 'username',

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Recipe::class,
        ]);
    }
}
