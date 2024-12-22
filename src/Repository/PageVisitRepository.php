<?php

namespace App\Repository;

use App\Entity\PageVisit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageVisit>
 */
class PageVisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageVisit::class);
    }

    public function save(PageVisit $pageVisit, bool $flush = false): void
    {
        $this->getEntityManager()->persist($pageVisit);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PageVisit $pageVisit, bool $flush = false): void
    {
        $this->getEntityManager()->remove($pageVisit);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}