<?php

namespace App\DataFixtures;

use App\Entity\Deal;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class DealFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=20; $i++){
            $deal = new Deal();
            $date = (new DateTime('now'))->modify("+ ". rand(0,10) ." days");
            $deal->setNom("Nom".$i)
                ->setDateExpiration($date)
                ->setDatePublication($date)
                ->setDegreAttractivite($i * 15)
                ->setDescription("Description".$i)
                ->setFraisLivraison($i)
                ->setLien("http://lien.fr")
                ->setPostePar($manager->getRepository(User::class)->findOneBy(["username" => "username1"]))
                ->setPrixHabituel(50)
                ->setPrixReduction(25);

            $manager->persist($deal);
        }
        $manager->flush();
    }

    /**
     * Méthode à implémenter de OrderedFixtureInterface
     */
    public function getOrder(): int
    {
        return 10;
    }
}
