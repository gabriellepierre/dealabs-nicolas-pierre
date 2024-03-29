<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'postePar', targetEntity: Deal::class)]
    private Collection $deals;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserDealInteraction::class, orphanRemoval: true)]
    private Collection $userDealInteractions;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $photoProfil = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
        $this->userDealInteractions = new ArrayCollection();
    }



    /**
     * Méthodes créées
     */
    public function __toString()
    {
        return $this->username;
    }

    public function getDealsSaved(): array
    {
        $dealsSaved = [];
        foreach($this->getUserDealInteractions() as $interaction){
            if($interaction->isDealSaved()){
                $dealsSaved[] = $interaction->getDeal();
            }
        }
        return $dealsSaved;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return Collection<int, Deal>
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals->add($deal);
            $deal->setPostePar($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getPostePar() === $this) {
                $deal->setPostePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserDealInteraction>
     */
    public function getUserDealInteractions(): Collection
    {
        return $this->userDealInteractions;
    }

    public function addUserDealInteraction(UserDealInteraction $userDealInteraction): self
    {
        if (!$this->userDealInteractions->contains($userDealInteraction)) {
            $this->userDealInteractions->add($userDealInteraction);
            $userDealInteraction->setUser($this);
        }

        return $this;
    }

    public function removeUserDealInteraction(UserDealInteraction $userDealInteraction): self
    {
        if ($this->userDealInteractions->removeElement($userDealInteraction)) {
            // set the owning side to null (unless already changed)
            if ($userDealInteraction->getUser() === $this) {
                $userDealInteraction->setUser(null);
            }
        }

        return $this;
    }

    public function getPhotoProfil(): ?Image
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(?Image $photoProfil): self
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
