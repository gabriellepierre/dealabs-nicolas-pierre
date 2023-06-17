<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodePromoRepository::class)]
class CodePromo extends Deal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $typeCodePromo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCodePromo(): ?int
    {
        return $this->typeCodePromo;
    }

    /**
     * 1- Pourcentage (%)
     * 2- Euro (€)
     * 3- Livraison gratuite
     */
    public function setTypeCodePromo(int $typeCodePromo): self
    {
        $this->typeCodePromo = $typeCodePromo;

        return $this;
    }
}
