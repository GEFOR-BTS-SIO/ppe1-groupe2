<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/eleve/crud')]
class EleveCrudController extends AbstractController

{

    private function hashPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    #[Route('/', name: 'app_eleve_crud_index', methods: ['GET'])]
    public function index(EleveRepository $eleveRepository): Response
    {
        
        return $this->render('eleve_crud/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eleve_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request,SluggerInterface $slugger, EleveRepository $eleveRepository): Response
    {
        // Vérifiez le rôle de l'utilisateur
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Accès interdit');
        }
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();

            // Vérifier si un nouveau mot de passe a été saisi
            if (!empty($plainPassword)) {
                // Hacher le mot de passe
                $hashedPassword = $this->hashPassword($plainPassword);

                // Définir le mot de passe haché dans l'entité Eleve
                $eleve->setPassword($hashedPassword);
            }
            
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('photo_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'image' property to store the IMAGE file name
                // instead of its contents
                $eleve->setPhoto($newFilename);
            }
            $eleveRepository->save($eleve, true);

            return $this->redirectToRoute('app_eleve_crud_index', [], Response::HTTP_SEE_OTHER);
        }
        dump($eleve) ;

        return $this->render('eleve_crud/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    #[Route('/search', name: 'app_eleve_search', methods: ['GET'])]
    public function search(Request $request, EleveRepository $eleveRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Accès interdit');
        }
        $searchTerm = $request->query->get('b');
        $eleves = $eleveRepository->search($searchTerm);
    
        $message = '';
        if (empty($eleves)) {
            $message = "Aucun élève trouvé pour la recherche : '$searchTerm'";
        }
    
        return $this->render('eleve_crud/index.html.twig', [
            'eleves' => $eleves,
            'searchTerm' => $searchTerm,
            'message' => $message,
        ]);
    }
    
    

    #[Route('/{id}', name: 'app_eleve_crud_show', methods: ['GET'])]
    public function show(Eleve $eleve): Response
    {
        
        return $this->render('eleve_crud/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eleve_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,SluggerInterface $slugger, Eleve $eleve, EleveRepository $eleveRepository): Response
    {

        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Accès interdit');
        }
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le mot de passe saisi
            $plainPassword = $form->get('password')->getData();

            // Vérifier si un nouveau mot de passe a été saisi
            if (!empty($plainPassword)) {
                // Hacher le mot de passe
                $hashedPassword = $this->hashPassword($plainPassword);

                // Définir le mot de passe haché dans l'entité Eleve
                $eleve->setPassword($hashedPassword);
            }

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('photo_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'image' property to store the IMAGE file name
                // instead of its contents
                $eleve->setPhoto($newFilename);
            }
            $eleveRepository->save($eleve, true);

                return $this->redirectToRoute('app_eleve_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleve_crud/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
            
        ]);
    }
    

    #[Route('/{id}', name: 'app_eleve_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Eleve $eleve, EleveRepository $eleveRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Accès interdit');
        }
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->request->get('_token'))) {
            $eleveRepository->remove($eleve, true);
        }

        return $this->redirectToRoute('app_eleve_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
