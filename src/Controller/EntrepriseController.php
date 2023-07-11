<?php

namespace App\Controller;

use App\Form\EntrepriseType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;                                                 // if index(EntityManagerInterface $entityManager)
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Entreprise;                                                               // if index(EntityManagerInterface $entityManager)
use App\Repository\EntrepriseRepository;                                                    // if index(EntrepriseRepository $entrepriseRepository)

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $name = "Brice";
        // $tableau = ["val-1","val-2","val-3","val-4"];
        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();      // if index(EntityManagerInterface $entityManager)
    $entreprises = $entrepriseRepository->findBy([/*'ville' => 'Strasbourg'*/],["raisonSocial" => "ASC"]);         // if index(EntrepriseRepository $entrepriseRepository) + findBy ici = SELECT * FROM entreprise ORDER BY raisonSocial ASC
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
            // 'name' => $name,
            // 'tab' => $tableau
        ]);
    }

    #[Route('/entreprise/new', name: 'new_entreprise')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entreprise = new Entreprise();

        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entreprise = $form->getData();
            $entityManager->persist($entreprise);   // prepare PDO
            $entityManager->flush();                // execute PDO

            return $this->redirectToRoute('app_entreprise');
        }

        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form
        ]);
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig',[
            'entreprise' => $entreprise
        ]);
    }
}
