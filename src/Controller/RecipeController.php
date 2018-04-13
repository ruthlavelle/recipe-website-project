<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class RecipeController extends Controller
{

    /**
     * @Route("/recipe/new", name="recipe_new_form")
     */
    public function newFormAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createFormBuilder($recipe)
            ->add('image', TextType::class)
            ->add('title', TextType::class)
            ->add('summary', TextType::class)
            ->add('tags', TextType::class)
            ->add('listOfIngredients', TextType::class)
            ->add('sequenceOfSteps', TextType::class)
            ->add('user', EntityType::class, [
                'class' => 'App:User' ,
                'choice_label' => 'username',
            ])
            ->add('save', SubmitType::class, array('label' => 'Create New Recipe'))->getForm();

        $argsArray = [
            'form' => $form->createView(),
        ];

        $templateName='recipe/new';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/recipe/processNewForm", name="recipe_process_new_form")
     */
    public function processNewFormAction(Request $request)
    {
        //extract data from post values
        $image = $request->request->get('image');
        $title = $request->request->get('title');
        $summary = $request->request->get('summary');
        $tags = $request->request->get('tags');
        $listOfIngredients = $request->request->get('listOfIngredients');
        $sequenceOfSteps= $request->request->get('sequenceOfSteps');
        $user=$request->request->get('user');

        //valid if none of the values are empty
        $isValid= !empty($title) && !empty($summary) && !empty($tags) && !empty($listOfIngredients) && !empty($sequenceOfSteps);

        if(!$isValid){
            $this->addFlash(
                'error',
                'None of these fields can be left empty'
            );
        }

        //forward to the createAction() method
        return $this->createAction($image, $title,$summary, $tags, $listOfIngredients, $sequenceOfSteps, $user);
    }

    /**
     * @Route("/recipe/new", name="recipe_new", methods={"POST", "GET"})
     */
    public function newAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form -> isValid()){
            return $this->createAction($recipe);
        }

        $template = 'recipe/new.html.twig';
        $argsArray = [
            'form' => $form->createView(),
        ];

        return $this->render($template, $argsArray);
    }

    /**
     * @Route("/recipe", name="recipe_list")
     */
    public function listAction()
    {
        $recipeRepository = $this->getDoctrine()->getRepository('App:Recipe');
        $recipes = $recipeRepository->findAll();

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
     * @Route("/recipe/delete/{id}")
     */
    public function deleteAction(Recipe $recipe)
    {
        //entity manager
        $em = $this->getDoctrine()->getManager();

        //Store id before deleting
        $id = $recipe->getId();

        //tell doctrine to delete student
        $em->remove($recipe);

        //execute
        $em->flush();

        return new Response('Deleted Recipe with ID: ' .$id);
    }

    /**
     * @Route("/recipe/update/{id}/{newTitle}/{newSummary}/{newTags}/{newListOfIngredients}/{newSequenceOfSteps}")
     */
    public function updateAction(Recipe $recipe, $newImage, $newTitle, $newSummary, $newTags, $newListOfIngredients, $newSequenceOfSteps)
    {
        $em = $this->getDoctrine()->getManager();

        $recipe->setImage($newImage);
        $recipe->setTitle($newTitle);
        $recipe->setSummary($newSummary);
        $recipe->setTags($newTags);
        $recipe->setListOfIngredients($newListOfIngredients);
        $recipe->setSequenceOfSteps($newSequenceOfSteps);
        $em->flush();

        return $this->redirectToRoute('student_show', ['id' => $recipe->getId()]);
    }

    /**
     * @Route ("/recipe/{id}", name="recipe_show")
     */
    public function showAction(Recipe $recipe)
    {
        $template = 'recipe/index.html.twig';

        $args = [
            'recipe' => $recipe
        ];

        if(!$recipe){
            $template='error/404.html.twig';
        }

        return $this->render($template, $args);
    }


}

?>
