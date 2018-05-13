<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index()
    {
        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAll();

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $template = 'admin/index.html.twig';

        $args = [
            'recipes' => $recipes,
            'users' => $users
        ];

       return $this->render($template, $args);
    }

    /**
     * @Route("/user/delete/{id}", name="delete_user")
     */
    public function delete(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository
        (User::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin');
    }
}
