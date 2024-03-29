<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DealRepository;
use App\Entity\UserDealInteraction;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DealRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['bon_plan' => 'BonPlan', 'code_promo' => 'CodePromo'])]
abstract class Deal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $postePar = null;

    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $images;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'deals')]
    private Collection $categories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePromo = null;

    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: UserDealInteraction::class, orphanRemoval: true)]
    private Collection $userDealInteractions;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->userDealInteractions = new ArrayCollection();
    }



    /**
     * Méthodes créées
     */
    public function getDegreAttractivite(): ?int
    {
        $degreAttractivite = 0;
        foreach($this->userDealInteractions as $interaction){
            $degreAttractivite += $interaction->getLiked();
        }
        return $degreAttractivite;
    }

    public function getUserDealInteraction(User $user): ?UserDealInteraction
    {
        foreach($this->userDealInteractions as $interaction){
            if($interaction->getUser() === $user){
                return $interaction;
            }
        }
        return null;
    }

    public function getCommentaires(): array
    {
        $commentaires = [];
        foreach($this->userDealInteractions as $interaction){
            foreach($interaction->getCommentaires() as $commentaire){
                $commentaires[] = $commentaire;
            }
        }
        return $commentaires;
    }



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

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(?\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getPostePar(): ?User
    {
        return $this->postePar;
    }

    public function setPostePar(?User $postePar): self
    {
        $this->postePar = $postePar;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setDeal($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getDeal() === $this) {
                $image->setDeal(null);
            }
        }

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

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

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addDeal($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeDeal($this);
        }

        return $this;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): self
    {
        $this->codePromo = $codePromo;

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
            $userDealInteraction->setDeal($this);
        }

        return $this;
    }

    public function removeUserDealInteraction(UserDealInteraction $userDealInteraction): self
    {
        if ($this->userDealInteractions->removeElement($userDealInteraction)) {
            // set the owning side to null (unless already changed)
            if ($userDealInteraction->getDeal() === $this) {
                $userDealInteraction->setDeal(null);
            }
        }

        return $this;
    }
}
