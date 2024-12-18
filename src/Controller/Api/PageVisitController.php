<?php



namespace App\Controller\Api;

use App\Repository\PageVisitRepository;
use App\Entity\PageVisit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/visit', name: 'api_visit_')]
class PageVisitController extends AbstractController
{
    private PageVisitRepository $pageVisitRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PageVisitRepository $pageVisitRepository, EntityManagerInterface $entityManager)
    {
        $this->pageVisitRepository = $pageVisitRepository;
        $this->entityManager = $entityManager;
    }

    // Méthode pour enregistrer une visite (POST)
    #[Route('/{pageUrl}', methods: ['POST'], name: 'record_visit')]
    public function recordVisit(string $pageUrl): JsonResponse
    {
        $pageVisit = $this->pageVisitRepository->findOneBy(['pageUrl' => $pageUrl]);

        if (!$pageVisit) {
            $pageVisit = new PageVisit();
            $pageVisit->setPageUrl($pageUrl);
            $pageVisit->setVisitCount(0);
        }

        // Incrémenter le compteur de visites
        $pageVisit->incrementVisitCount();

        // Sauvegarder dans la base de données
        $this->entityManager->persist($pageVisit);
        $this->entityManager->flush();

        return new JsonResponse([
            'pageUrl' => $pageVisit->getPageUrl(),
            'visitCount' => $pageVisit->getVisitCount(),
        ]);
    }

    // Méthode pour récupérer toutes les visites de pages (GET)
    #[Route('', methods: ['GET'], name: 'get_all_visits')]
    public function getAllVisits(): JsonResponse
    {
        // Récupérer toutes les pages de visite avec leur nombre de visites
        $pageVisits = $this->pageVisitRepository->findAll();

        // Transformer les données en tableau simple pour la réponse JSON
        $data = [];
        foreach ($pageVisits as $pageVisit) {
            // Exclure la page "/dashboard"
            if ($pageVisit->getPageUrl() !== 'dashboard') {
                $data[] = [
                    'pageUrl' => $pageVisit->getPageUrl(),
                    'visitCount' => $pageVisit->getVisitCount(),
                ];
            }
        }

        return new JsonResponse($data);
    }
}