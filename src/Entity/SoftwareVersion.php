<?php

namespace App\Entity;

use App\Repository\SoftwareVersionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoftwareVersionRepository::class)]
class SoftwareVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $systemVersion = null;

    #[ORM\Column(length: 255)]
    private ?string $systemVersionAlt = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $link = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $st = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $gd = null;

    #[ORM\Column(type: 'boolean')]
    private bool $latest = false;

    #[ORM\Column(type: 'boolean')]
    private bool $isLci = false;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $lciType = null;

    // Getters & Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSystemVersion(): ?string
    {
        return $this->systemVersion;
    }

    public function setSystemVersion(string $systemVersion): self
    {
        $this->systemVersion = $systemVersion;
        return $this;
    }

    public function getSystemVersionAlt(): ?string
    {
        return $this->systemVersionAlt;
    }

    public function setSystemVersionAlt(string $systemVersionAlt): self
    {
        $this->systemVersionAlt = $systemVersionAlt;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function getSt(): ?string
    {
        return $this->st;
    }

    public function setSt(?string $st): self
    {
        $this->st = $st;
        return $this;
    }

    public function getGd(): ?string
    {
        return $this->gd;
    }

    public function setGd(?string $gd): self
    {
        $this->gd = $gd;
        return $this;
    }

    public function isLatest(): bool
    {
        return $this->latest;
    }

    public function setLatest(bool $latest): self
    {
        $this->latest = $latest;
        return $this;
    }

    public function isIsLci(): bool
    {
        return $this->isLci;
    }

    public function setIsLci(bool $isLci): self
    {
        $this->isLci = $isLci;
        return $this;
    }

    public function getLciType(): ?string
    {
        return $this->lciType;
    }

    public function setLciType(?string $lciType): self
    {
        $this->lciType = $lciType;
        return $this;
    }
}
