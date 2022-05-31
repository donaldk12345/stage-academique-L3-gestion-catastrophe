<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 */
class Pays
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
     * @ORM\OneToMany(targetEntity=Catastrophe::class, mappedBy="pays")
     */
    private $paysSelect;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userSelect")
     */
    private $users;

    public function __construct()
    {
        $this->paysSelect = new ArrayCollection();
        $this->users = new ArrayCollection();
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
    public function getPaysSelect(): Collection
    {
        return $this->paysSelect;
    }

    public function addPaysSelect(Catastrophe $paysSelect): self
    {
        if (!$this->paysSelect->contains($paysSelect)) {
            $this->paysSelect[] = $paysSelect;
            $paysSelect->setPays($this);
        }

        return $this;
    }

    public function removePaysSelect(Catastrophe $paysSelect): self
    {
        if ($this->paysSelect->removeElement($paysSelect)) {
            // set the owning side to null (unless already changed)
            if ($paysSelect->getPays() === $this) {
                $paysSelect->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUserSelect($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUserSelect() === $this) {
                $user->setUserSelect(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
