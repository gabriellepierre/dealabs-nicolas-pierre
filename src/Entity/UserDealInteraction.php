<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\UserDealInteractionRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserDealInteractionRepository::class)]
#[UniqueEntity(fields: ['user', 'deal'])]
class UserDealInteraction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userDealInteractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userDealInteractions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Deal $deal = null;

    /**
     * 0 : Ni like ni dislike du deal
     * 1 : Like du deal
     * -1 : Dislike du deal
     */
    #[ORM\Column]
    private int $liked = 0;

    #[ORM\OneToMany(mappedBy: 'userDealInteraction', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\Column]
    private ?bool $dealSaved = false;

    public function __construct(User $user, Deal $deal)
    {
        $this->user = $user;
        $this->deal = $deal;
        $this->commentaires = new ArrayCollection();

        $this->user->addUserDealInteraction($this);
        $this->deal->addUserDealInteraction($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDeal(): ?Deal
    {
        return $this->deal;
    }

    public function setDeal(?Deal $deal): self
    {
        $this->deal = $deal;

        return $this;
    }

    public function getLiked(): ?int
    {
        return $this->liked;
    }

    public function setLiked(?int $liked): self
    {
        $this->liked = $liked;
        
        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUserDealInteraction($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUserDealInteraction() === $this) {
                $commentaire->setUserDealInteraction(null);
            }
        }

        return $this;
    }

    public function isDealSaved(): ?bool
    {
        return $this->dealSaved;
    }

    public function setDealSaved(bool $dealSaved): self
    {
        $this->dealSaved = $dealSaved;

        return $this;
    }
}
