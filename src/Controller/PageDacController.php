<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageDacController extends AbstractController
{
    #[Route('/', name: 'app_page_dac')]
    public function index(): Response
    {
        return $this->render('page_dac/index.html.twig', [
            'controller_name' => 'PageDacController',
        ]);
    }
}
