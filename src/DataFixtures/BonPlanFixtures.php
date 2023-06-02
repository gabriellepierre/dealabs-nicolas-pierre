<?php

namespace App\DataFixtures;

use App\Entity\BonPlan;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class BonPlanFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=20; $i++){
            $bonPlan = new BonPlan();
            $bonPlan->setNom("Nom".$i)
                ->setDateExpiration(new DateTime('now'))
                ->setDatePublication(new DateTime('now'))
                ->setDegreAttractivite($i)
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
        return 10;
    }
}
