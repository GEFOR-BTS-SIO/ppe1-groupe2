<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LesFormationController extends AbstractController
{
    #[Route('/LesFormation', name: 'app_Lesformation_index')]
    public function profilIndex(Request $request, EleveRepository $eleveRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'required'   => false
            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label'  => 'cursus'
            ])
            ->add('valider', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $eleves = $eleveRepository->findByRole('ROLE_USER', $form->get('name')->getData(), $form->get('formation')->getData());
        } else {
            $eleves = $eleveRepository->findByRole('ROLE_USER');
        }
        return $this->render('les_formation/index.html.twig', [
            'eleve' => $eleves,
            'form' => $form->createView()
        ]);
       
        
    }
    
    
}


