<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotMdpController extends AbstractController
{
    #[Route('/forgot/mdp', name: 'app_forgot_mdp')]
    public function index(): Response
    {
        return $this->render('forgot_mdp/index.html.twig', [
            'controller_name' => 'ForgotMdpController',
        ]);
    }
}
