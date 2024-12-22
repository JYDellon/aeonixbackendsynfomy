<?php

namespace App\Controller;

use App\Entity\PageVisit;
use App\Repository\PageVisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageVisitController extends AbstractController
{
    #[Route('/api/visit/{pageUrl}', name: 'api_record_visit', methods: ['POST'])]
    public function recordVisit(
        string $pageUrl,
        PageVisitRepository $repository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $pageVisit = $repository->findOneBy(['pageUrl' => $pageUrl]);

        if (!$pageVisit) {
            $pageVisit = new PageVisit();
            $pageVisit->setPageUrl($pageUrl);
        }

        $pageVisit->incrementVisitCount();
        $entityManager->persist($pageVisit);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Visite enregistrée avec succès.',
            'pageUrl' => $pageVisit->getPageUrl(),
            'visitCount' => $pageVisit->getVisitCount(),
        ]);
    }

    #[Route('/api/visit', name: 'api_get_visits', methods: ['GET'])]
    public function getVisits(PageVisitRepository $repository): JsonResponse
    {
        $visits = $repository->findAll();

        $data = array_map(function (PageVisit $visit) {
            return [
                'pageUrl' => $visit->getPageUrl(),
                'visitCount' => $visit->getVisitCount(),
            ];
        }, $visits);

        return new JsonResponse($data);
    }

    #[Route('/api/visit', name: 'api_reset_visits', methods: ['DELETE'])]
    public function resetVisits(PageVisitRepository $repository, EntityManagerInterface $entityManager): JsonResponse
    {
        $visits = $repository->findAll();

        foreach ($visits as $visit) {
            $entityManager->remove($visit);
        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Toutes les visites ont été réinitialisées.']);
    }
}