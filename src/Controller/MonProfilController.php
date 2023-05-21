<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{
    #[Route('/mon/profil', name: 'app_mon_profil')]
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('mon_profil/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }
}
