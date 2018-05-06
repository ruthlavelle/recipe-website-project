<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_USER')")
     */
    public function index()
    {
       $template = 'admin/index.html.twig';
       $args = [];

       return $this->render($template, $args);
    }
}
