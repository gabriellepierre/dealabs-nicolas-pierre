<?php

namespace App\DataFixtures;

use App\Entity\Deal;
use App\Entity\User;
use App\Entity\UserDealInteraction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserDealInteractionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach($manager->getRepository(Deal::class)->findAll() as $deal){
            foreach($manager->getRepository(User::class)->findAll() as $user){
                $interaction = new UserDealInteraction($user,$deal);

                $interaction->setLiked(rand(-1,1));
                
                $manager->persist($interaction);
            }
            $manager->flush();
        }
        
    }

    /**
     * Méthode à implémenter de OrderedFixtureInterface
     */
    public function getOrder(): int
    {
        return 10;
    }
}
