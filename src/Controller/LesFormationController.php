<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LesFormationController extends AbstractController
{
    #[Route('/les/formation', name: 'app_les_formation')]
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('les_formation/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }
}
