<?php






// src/Repository/PageVisitRepository.php

namespace App\Repository;

use App\Entity\PageVisit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PageVisitRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, PageVisit::class);
        $this->entityManager = $entityManager;
    }

    public function findOrCreateByPageUrl(string $pageUrl): PageVisit
    {
        // Chercher une page existante dans la base de données
        $pageVisit = $this->findOneBy(['pageUrl' => $pageUrl]);

        if (!$pageVisit) {
            // Si la page n'existe pas, on la crée
            $pageVisit = new PageVisit();
            $pageVisit->setPageUrl($pageUrl);
            $pageVisit->setVisitCount(0); // Initialiser à 0 les visites
            $this->entityManager->persist($pageVisit); // Persist la nouvelle entité
        }

        // Incrémenter le compteur de visites
        $pageVisit->setVisitCount($pageVisit->getVisitCount() + 1);

        // Persist la mise à jour de l'entité
        $this->entityManager->flush();

        return $pageVisit;
    }
}