<?php
/**
 * Created by PhpStorm.
 * User: ruthl
 * Date: 08/04/2018
 * Time: 17:21
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        $template = 'security/login.html.twig';
        $args = [
            'last_username' => $lastUsername,
            'error' => $error,
        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/user/new", name="user_new_form")
     */
    public function newFormAction(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create New User'))->getForm();

        $argsArray = [
            'form' => $form->createView(),
        ];

        $templateName='security/new';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/user/processNewForm", name="user_process_new_form")
     */
    public function processNewFormAction(Request $request)
    {
        //extract data from post values
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        //valid if none of the values are empty
        $isValid= !empty($username) && !empty($password);

        if(!$isValid){
            $this->addFlash(
                'error',
                'None of these fields can be left empty'
            );
        }

        //forward to the createAction() method
        return $this->createAction($username, $password);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"POST", "GET"})
     */
    public function newAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form -> isValid()){
            return $this->createAction($user);
        }

        $template = 'user/new.html.twig';
        $argsArray = [
            'form' => $form->createView(),
        ];

        return $this->render($template, $argsArray);
    }

    /**
     * @Route("/user/create/{username}/{password}")
     */
    public function createAction($user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->listAction($user->getId());
    }

}