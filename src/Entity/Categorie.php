<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity=Catastrophe::class, mappedBy="categorie")
     */
    private $categorieSelect;

    public function __construct()
    {
        $this->categorieSelect = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Catastrophe>
     */
    public function getCategorieSelect(): Collection
    {
        return $this->categorieSelect;
    }

    public function addCategorieSelect(Catastrophe $categorieSelect): self
    {
        if (!$this->categorieSelect->contains($categorieSelect)) {
            $this->categorieSelect[] = $categorieSelect;
            $categorieSelect->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorieSelect(Catastrophe $categorieSelect): self
    {
        if ($this->categorieSelect->removeElement($categorieSelect)) {
            // set the owning side to null (unless already changed)
            if ($categorieSelect->getCategorie() === $this) {
                $categorieSelect->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
