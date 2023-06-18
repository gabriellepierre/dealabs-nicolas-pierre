<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\BonPlan;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class BonPlanFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=20; $i++){
            $bonPlan = new BonPlan();
            $date = (new DateTime('now'))->modify("+ ". rand(0,10) ." days");
            $bonPlan->setTitre("BonPlan".$i)
                ->setDateExpiration($date)
                ->setDatePublication($date)
                ->setDescription("Description".$i)
                ->setFraisLivraison($i)
                ->setLien("http://lien.fr")
                ->setPostePar($manager->getRepository(User::class)->findOneBy(["username" => "username1"]))
                ->setPrixHabituel(50)
                ->setPrixReduction(25);

            $manager->persist($bonPlan);
        }
        $manager->flush();
    }

    /**
     * Méthode à implémenter de OrderedFixtureInterface
     */
    public function getOrder(): int
    {
        return 5;
    }
}
