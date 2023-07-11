<?php

namespace App\Controller;

// use App\Entity\Entreprise;                                                               // if index(EntityManagerInterface $entityManager)
use App\Repository\EntrepriseRepository;                                                    // if index(EntrepriseRepository $entrepriseRepository)
// use Doctrine\ORM\EntityManagerInterface;                                                 // if index(EntityManagerInterface $entityManager)
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $name = "Brice";
        // $tableau = ["val-1","val-2","val-3","val-4"];
        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();      // if index(EntityManagerInterface $entityManager)
        $entreprises = $entrepriseRepository->findBy(['ville' => 'Strasbourg'],["raisonSocial" => "ASC"]);         // if index(EntrepriseRepository $entrepriseRepository) + findBy ici = SELECT * FROM entreprise ORDER BY raisonSocial ASC
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
            // 'name' => $name,
            // 'tab' => $tableau
        ]);
    }
}
