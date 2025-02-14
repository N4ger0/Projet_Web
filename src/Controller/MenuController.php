<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render('bienvenue.html.twig');
    }
}
