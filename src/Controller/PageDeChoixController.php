<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageDeChoixController extends AbstractController
{
    #[Route('/page/de/choix', name: 'app_page_de_choix')]
    public function index(): Response
    {
        return $this->render('page_de_choix/index.html.twig', [
            'controller_name' => 'PageDeChoixController',
        ]);
    }
}
