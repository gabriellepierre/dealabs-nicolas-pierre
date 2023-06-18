<?php

namespace App\Entity;

use App\Repository\BonPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonPlanRepository::class)]
class BonPlan extends Deal
{
    #[ORM\Column(nullable: true)]
    private ?float $prixHabituel = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixReduction = null;

    #[ORM\Column(nullable: true)]
    private ?float $fraisLivraison = null;
    
    public function getPrixHabituel(): ?float
    {
        return $this->prixHabituel;
    }

    public function setPrixHabituel(?float $prixHabituel): self
    {
        $this->prixHabituel = $prixHabituel;

        return $this;
    }

    public function getPrixReduction(): ?float
    {
        return $this->prixReduction;
    }

    public function setPrixReduction(?float $prixReduction): self
    {
        $this->prixReduction = $prixReduction;

        return $this;
    }
    
    public function getFraisLivraison(): ?float
    {
        return $this->fraisLivraison;
    }

    public function setFraisLivraison(?float $fraisLivraison): self
    {
        $this->fraisLivraison = $fraisLivraison;

        return $this;
    }
}
