<?php

namespace App\Entity;

use App\Repository\PageVisitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageVisitRepository::class)]
class PageVisit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $pageUrl = null;

    #[ORM\Column(type: 'integer')]
    private int $visitCount = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageUrl(): ?string
    {
        return $this->pageUrl;
    }

    public function setPageUrl(string $pageUrl): self
    {
        $this->pageUrl = $pageUrl;
        return $this;
    }

    public function getVisitCount(): int
    {
        return $this->visitCount;
    }

    public function incrementVisitCount(): self
    {
        $this->visitCount++;
        return $this;
    }
}