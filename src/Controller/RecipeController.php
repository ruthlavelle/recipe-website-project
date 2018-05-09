<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class RecipeController extends Controller
{

    /**
     * @Route("/recipe/new", name="recipe_new")
     * @Method({"POST", "GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newRecipe(Request $request, UserInterface $user)
    {
        $recipe = new Recipe();

        $recipe->setUser($user);

        $form = $this->createFormBuilder($recipe)
            ->add('image', FileType::class, array('label' => 'Image (png, jpeg)'))
            ->add('title', TextType::class)
            ->add('summary', TextareaType::class)
            ->add('tags', TextType::class)
            ->add('listOfIngredients', TextareaType::class)
            ->add('sequenceOfSteps', TextareaType::class)
            ->add('author', HiddenType::class, array(
                    'data' => $user->getUsername(),
                ))
            ->add('save', SubmitType::class, array('label' => 'Create New Recipe'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $recipe->getImage();
            $fileName = md5(uniqid()). '.' .$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $recipe->setImage($fileName);

            $recipe = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('recipe/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/recipe/edit/{id}", name="recipe_edit")
     * methods={"POST", "GET"}
     */
    public function editRecipe(Request $request, $id, UserInterface $user)
    {
        $recipe = new Recipe();
        $recipe->setUser($user);

        $recipe = $this->getDoctrine()->getRepository
        (Recipe::class)->find($id);
        $recipe->setImage(
            new File($this->getParameter('image_directory'). '/' .$recipe->getImage())
        );

        $form = $this->createFormBuilder($recipe)
            ->add('image', FileType::class, array('label' => 'Image (png, jpeg)'))
            ->add('title', TextType::class)
            ->add('summary', TextareaType::class)
            ->add('tags', TextType::class)
            ->add('listOfIngredients', TextareaType::class)
            ->add('sequenceOfSteps', TextareaType::class)
            ->add('author', HiddenType::class, array(
                'data' => $user->getUsername(),
            ))
            ->add('save', SubmitType::class, array('label' => 'Create New Recipe'))
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $file = $recipe->getImage();
            $fileName = md5(uniqid()). '.' .$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $recipe->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('recipe/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/recipe", name="recipe_list")
     */
    public function listAction()
    {
        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAll();

        $template = 'recipe/list.html.twig';
        $args = [
            'recipes' => $recipes
        ];

        return $this ->render($template, $args);
    }


    /**
     * @Route("/recipe/create/{title}/{summary}/{tags}/{listOfIngredients}/{sequenceOfSteps}")
     */
    public function createAction($recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return $this->listAction($recipe->getId());
    }

    /**
     * @Route("/recipe/delete/{id}", name="delete_recipe")
     */
    public function delete(Request $request, $id)
    {
        $recipe = $this->getDoctrine()->getRepository
        (Recipe::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('recipe_list');
    }


    /**
     * @Route ("/recipe/{id}", name="recipe_show")
     */
    public function showAction(Recipe $recipe)
    {
        $template = 'recipe/show.html.twig';

        $args = [
            'recipe' => $recipe
        ];

        if(!$recipe){
            $template='error/404.html.twig';
        }

        return $this->render($template, $args);
    }

    /**
     * @Route ("/collections", name="my_collection")
     */
    public function myCollection(UserInterface $user)
    {
        $id = $user->getId();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $recipes = $user->getRecipes();

        $args = [
            'recipes' => $recipes
        ];

        return $this->render('recipe/collection.html.twig', $args);
    }

    /**
     * @Route("/new/comment/{id}", name="new_comment")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newComment(UserInterface $user, Recipe $recipe, Request $request)
    {
        $comment = new Comment();
        $comment->setUser($user);
        $comment->setRecipe($recipe);

        $form = $this->createFormBuilder($comment)
            ->add('comment', TextareaType::class)
            ->add('author', HiddenType::class, array(
                'data' => $user->getUsername(),
            ))
            ->add('save', SubmitType::class, array('label' => 'Save Comment'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $comment = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('comment/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route ("/comments/{id}", name="recipe_comments", methods={"GET"})
     */
    public function recipeComments(Recipe $recipe)
    {
        $id = $recipe->getId();

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->find($id);

        $comments = $recipe->getComments();

        $args = [
            'comments' => $comments
        ];

        return $this->render('comment/show.html.twig', $args);
    }




}

?>
