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

    // #[Route('/pourquoi', name: 'app_page_pourquoi')]
    // public function Pourquoi(): Response
    // {
    //     return $this->render('page_dac/Pourquoi.html.twig', [
    //         'controller_name' => 'PageDacController',
    //     ]);
    // }

    // #[Route('/contact', name: 'app_page_contact')]
    // public function contact(): Response
    // {
    //     return $this->render('page_dac/contact.html.twig', [
    //         'controller_name' => 'PageDacController',
    //     ]);
    // }







}



