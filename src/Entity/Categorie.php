<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: BonPlan::class, inversedBy: 'categories')]
    private Collection $bonsPlans;

    public function __construct()
    {
        $this->bonsPlans = new ArrayCollection();
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
     * @return Collection<int, BonPlan>
     */
    public function getBonsPlans(): Collection
    {
        return $this->bonsPlans;
    }

    public function addBonsPlan(BonPlan $bonsPlan): self
    {
        if (!$this->bonsPlans->contains($bonsPlan)) {
            $this->bonsPlans->add($bonsPlan);
        }

        return $this;
    }

    public function removeBonsPlan(BonPlan $bonsPlan): self
    {
        $this->bonsPlans->removeElement($bonsPlan);

        return $this;
    }
}
