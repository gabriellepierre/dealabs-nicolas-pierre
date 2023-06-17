<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\CodePromo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CodePromoFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=20; $i++){
            $bonPlan = new CodePromo();
            $date = (new DateTime('now'))->modify("+ ". rand(0,10) ." days");
            $bonPlan->setTitre("CodePromo".$i)
                ->setDateExpiration($date)
                ->setDatePublication($date)
                ->setDegreAttractivite($i * 15)
                ->setDescription("Description".$i)
                ->setLien("http://lien.fr")
                ->setPostePar($manager->getRepository(User::class)->findOneBy(["username" => "username1"]))
                ->setTypeCodePromo($i % 3);

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
