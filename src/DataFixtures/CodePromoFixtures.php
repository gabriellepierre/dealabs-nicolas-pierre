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
            $codePromo = new CodePromo();
            $date = (new DateTime('now'))->modify("+ ". rand(0,10) ." days");
            $codePromo->setTitre("CodePromo".$i)
                ->setDateExpiration($date)
                ->setDatePublication($date)
                ->setDescription("Description".$i)
                ->setLien("http://lien.fr")
                ->setPostePar($manager->getRepository(User::class)->findOneBy(["username" => "username1"]))
                ->setTypeCodePromo($i % 3);

            $manager->persist($codePromo);
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
