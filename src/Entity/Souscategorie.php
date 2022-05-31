<?php

namespace App\Entity;

use App\Repository\SouscategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SouscategorieRepository::class)
 */
class Souscategorie
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
     * @ORM\OneToMany(targetEntity=Catastrophe::class, mappedBy="souscategorie")
     */
    private $souscategorieSelect;

    public function __construct()
    {
        $this->souscategorieSelect = new ArrayCollection();
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
    public function getSouscategorieSelect(): Collection
    {
        return $this->souscategorieSelect;
    }

    public function addSouscategorieSelect(Catastrophe $souscategorieSelect): self
    {
        if (!$this->souscategorieSelect->contains($souscategorieSelect)) {
            $this->souscategorieSelect[] = $souscategorieSelect;
            $souscategorieSelect->setSouscategorie($this);
        }

        return $this;
    }

    public function removeSouscategorieSelect(Catastrophe $souscategorieSelect): self
    {
        if ($this->souscategorieSelect->removeElement($souscategorieSelect)) {
            // set the owning side to null (unless already changed)
            if ($souscategorieSelect->getSouscategorie() === $this) {
                $souscategorieSelect->setSouscategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
