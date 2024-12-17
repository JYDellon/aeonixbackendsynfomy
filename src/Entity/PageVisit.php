<?php

namespace App\Entity;

use App\Repository\PageVisitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageVisitRepository::class)]
class PageVisit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pageUrl = null;

    #[ORM\Column]
    private ?int $visitCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageUrl(): ?string
    {
        return $this->pageUrl;
    }

    public function setPageUrl(string $pageUrl): static
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    public function getVisitCount(): ?int
    {
        return $this->visitCount;
    }

    public function setVisitCount(int $visitCount): static
    {
        $this->visitCount = $visitCount;

        return $this;
    }

       // Méthode pour incrémenter le compteur de visites
       public function incrementVisitCount(): self
       {
           $this->visitCount++;
           return $this;
       }
}