<?php

namespace App\Entity;

use App\Repository\PreventionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

/**
 * @ORM\Entity(repositoryClass=PreventionRepository::class)
 */
#[Broadcast]
class Prevention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Catastrophe::class, inversedBy="preventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $catastrophe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="preventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prevent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCatastrophe(): ?Catastrophe
    {
        return $this->catastrophe;
    }

    public function setCatastrophe(?Catastrophe $catastrophe): self
    {
        $this->catastrophe = $catastrophe;

        return $this;
    }

    public function getPrevent(): ?User
    {
        return $this->prevent;
    }

    public function setPrevent(?User $prevent): self
    {
        $this->prevent = $prevent;

        return $this;
    }
}
