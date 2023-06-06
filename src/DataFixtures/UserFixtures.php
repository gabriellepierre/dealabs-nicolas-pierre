<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    public function __construct (
        private UserPasswordHasherInterface $userPasswordHasherInterface
    ) {}

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=5; $i++){
            $user = new User();
            $user->setUsername("username".$i)
                ->setEmail("email".$i."@com")
                ->setPassword("test");
            $this->hashUserPassword($user);

            $manager->persist($user);
        }
        $manager->flush();
    }

        
    public function hashUserPassword(User $user): void
    {
        $this->userPasswordHasherInterface->hashPassword($user, $user->getPassword());
    }

    /**
     * Méthode à implémenter de OrderedFixtureInterface
     */
    public function getOrder(): int
    {
        return 1;
    }
}
