<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Catastrophe::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $imagesSelect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImagesSelect(): ?Catastrophe
    {
        return $this->imagesSelect;
    }

    public function setImagesSelect(?Catastrophe $imagesSelect): self
    {
        $this->imagesSelect = $imagesSelect;

        return $this;
    }
}
