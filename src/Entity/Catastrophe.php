<?php

namespace App\Entity;

use DateTime;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PaysRepository;
use App\Repository\CatastropheRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=CatastropheRepository::class)
 */
class Catastrophe
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
    private $localisation;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreMort;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreBlesses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCatastrophe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $autresVictimes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sansAbris;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dimension;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $causeCatastrophe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="catastrophes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $catastrophe;

    /**
     * @ORM\ManyToOne(targetEntity=Continent::class, inversedBy="continentSelect")
     * @ORM\JoinColumn(nullable=false)
     */
    private $continent;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="categorieSelect")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Souscategorie::class, inversedBy="souscategorieSelect")
     * @ORM\JoinColumn(nullable=false)
     */
    private $souscategorie;

      /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="paysSelect")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="imagesSelect",cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $couts;

    /**
     * @ORM\OneToMany(targetEntity=Prevention::class, mappedBy="catastrophe")
     */
    private $preventions;

        /**
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate 
     * @return void 
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify= new Slugify();
            $this->slug =$slugify->slugify($this->nomCatastrophe);
        }
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->preventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

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

    public function getNombreMort(): ?int
    {
        return $this->nombreMort;
    }

    public function setNombreMort(int $nombreMort): self
    {
        $this->nombreMort = $nombreMort;

        return $this;
    }

    public function getNombreBlesses(): ?int
    {
        return $this->nombreBlesses;
    }

    public function setNombreBlesses(int $nombreBlesses): self
    {
        $this->nombreBlesses = $nombreBlesses;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNomCatastrophe(): ?string
    {
        return $this->nomCatastrophe;
    }

    public function setNomCatastrophe(string $nomCatastrophe): self
    {
        $this->nomCatastrophe = $nomCatastrophe;

        return $this;
    }

    public function getAutresVictimes(): ?int
    {
        return $this->autresVictimes;
    }

    public function setAutresVictimes(?int $autresVictimes): self
    {
        $this->autresVictimes = $autresVictimes;

        return $this;
    }

    public function getSansAbris(): ?int
    {
        return $this->sansAbris;
    }

    public function setSansAbris(?int $sansAbris): self
    {
        $this->sansAbris = $sansAbris;

        return $this;
    }

    public function getDimension(): ?float
    {
        return $this->dimension;
    }

    public function setDimension(?float $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getCauseCatastrophe(): ?string
    {
        return $this->causeCatastrophe;
    }

    public function setCauseCatastrophe(string $causeCatastrophe): self
    {
        $this->causeCatastrophe = $causeCatastrophe;

        return $this;
    }

    public function getCatastrophe(): ?User
    {
        return $this->catastrophe;
    }

    public function setCatastrophe(?User $catastrophe): self
    {
        $this->catastrophe = $catastrophe;

        return $this;
    }

    public function getContinent(): ?Continent
    {
        return $this->continent;
    }

    public function setContinent(?Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSouscategorie(): ?Souscategorie
    {
        return $this->souscategorie;
    }

    public function setSouscategorie(?Souscategorie $souscategorie): self
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

  

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setImagesSelect($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getImagesSelect() === $this) {
                $image->setImagesSelect(null);
            }
        }

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getCouts(): ?int
    {
        return $this->couts;
    }

    public function setCouts(?int $couts): self
    {
        $this->couts = $couts;

        return $this;
    }

    /**
     * @return Collection<int, Prevention>
     */
    public function getPreventions(): Collection
    {
        return $this->preventions;
    }

    public function addPrevention(Prevention $prevention): self
    {
        if (!$this->preventions->contains($prevention)) {
            $this->preventions[] = $prevention;
            $prevention->setCatastrophe($this);
        }

        return $this;
    }

    public function removePrevention(Prevention $prevention): self
    {
        if ($this->preventions->removeElement($prevention)) {
            // set the owning side to null (unless already changed)
            if ($prevention->getCatastrophe() === $this) {
                $prevention->setCatastrophe(null);
            }
        }

        return $this;
    }
}
