<?php

namespace App\Entity;

use DateTimeImmutable;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(
 * fields= {"email"},
 * message= "L'email que vous avez indiquez est déja utilisé !"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLE_USER='ROLE_USER';
    const ROLE_ADMIN= 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit faire minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password",message="Votre mot de passe doit être le  même  ")
     */
    private $password;
        /**
     * @Assert\EqualTo(propertyPath="password",message="Votre mot de passe doit être le  même  ")
     */
    public $confirm_password;

   /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUser;
    
     /**
     * @var File
     * @Vich\UploadableField(mapping="blog_images", fileNameProperty="imageUser")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Catastrophe::class, mappedBy="catastrophe")
     */
    private $catastrophes;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userSelect;

    /**
     * @ORM\OneToMany(targetEntity=Prevention::class, mappedBy="prevent")
     */
    private $preventions;

    public function __construct()
    {
        $this->catastrophes = new ArrayCollection();
        $this->preventions = new ArrayCollection();
    }
    /**
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate 
     * @return void 
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify= new Slugify();
            $this->slug =$slugify->slugify($this->email);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

     /**
     * @return string 
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
     /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    public function gravata(?int $size=100){
        return sprintf('https://www.gravatar.com/avatar/%s/?s=%d', md5(strtolower(trim($this->getEmail()))),$size);

    }

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
        
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getImageUser(): ?string
    {
        return $this->imageUser;
    }

    public function setImageUser(string $imageUser): self
    {
        $this->imageUser = $imageUser;

        return $this;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageUser = null): void
    {
        $this->imageFile = $imageUser;

        if (null !== $imageUser) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setcreatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return Collection<int, Catastrophe>
     */
    public function getCatastrophes(): Collection
    {
        return $this->catastrophes;
    }

    public function addCatastrophe(Catastrophe $catastrophe): self
    {
        if (!$this->catastrophes->contains($catastrophe)) {
            $this->catastrophes[] = $catastrophe;
            $catastrophe->setCatastrophe($this);
        }

        return $this;
    }

    public function removeCatastrophe(Catastrophe $catastrophe): self
    {
        if ($this->catastrophes->removeElement($catastrophe)) {
            // set the owning side to null (unless already changed)
            if ($catastrophe->getCatastrophe() === $this) {
                $catastrophe->setCatastrophe(null);
            }
        }

        return $this;
    }

    public function getUserSelect(): ?Pays
    {
        return $this->userSelect;
    }

    public function setUserSelect(?Pays $userSelect): self
    {
        $this->userSelect = $userSelect;

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
            $prevention->setPrevent($this);
        }

        return $this;
    }

    public function removePrevention(Prevention $prevention): self
    {
        if ($this->preventions->removeElement($prevention)) {
            // set the owning side to null (unless already changed)
            if ($prevention->getPrevent() === $this) {
                $prevention->setPrevent(null);
            }
        }

        return $this;
    }
 
}
