<?php

namespace App\Entity;

use App\Repository\ContinentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContinentRepository::class)
 */
class Continent
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
     * @ORM\OneToMany(targetEntity=Catastrophe::class, mappedBy="continent")
     */
    private $continentSelect;

    public function __construct()
    {
        $this->continentSelect = new ArrayCollection();
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
    public function getContinentSelect(): Collection
    {
        return $this->continentSelect;
    }

    public function addContinentSelect(Catastrophe $continentSelect): self
    {
        if (!$this->continentSelect->contains($continentSelect)) {
            $this->continentSelect[] = $continentSelect;
            $continentSelect->setContinent($this);
        }

        return $this;
    }

    public function removeContinentSelect(Catastrophe $continentSelect): self
    {
        if ($this->continentSelect->removeElement($continentSelect)) {
            // set the owning side to null (unless already changed)
            if ($continentSelect->getContinent() === $this) {
                $continentSelect->setContinent(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
