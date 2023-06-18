<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use App\Entity\UserDealInteraction;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CommentaireFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach($manager->getRepository(UserDealInteraction::class)->findAll() as $interaction){
            $commentaire = new Commentaire($interaction);

            $commentaire->setCommentaire("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nunc mi ipsum faucibus vitae aliquet. Lacinia quis vel eros donec ac odio tempor orci dapibus. Vestibulum lectus mauris ultrices eros in. Lorem ipsum dolor sit amet consectetur adipiscing elit ut. Eu volutpat odio facilisis mauris sit amet massa vitae tortor. Eros in cursus turpis massa tincidunt dui. Vitae turpis massa sed elementum tempus. Eget mi proin sed libero enim sed. Ante in nibh mauris cursus mattis molestie a iaculis at. Convallis convallis tellus id interdum. Volutpat est velit egestas dui id. Amet cursus sit amet dictum sit amet justo donec. Ac felis donec et odio pellentesque diam volutpat commodo. Mi in nulla posuere sollicitudin aliquam ultrices sagittis. Rhoncus dolor purus non enim praesent elementum facilisis. Diam vulputate ut pharetra sit. Faucibus interdum posuere lorem ipsum dolor sit amet.");
            $commentaire->setDatePublication((new DateTime('now'))->modify("+ ". rand(0,10) ." days"));

            $manager->persist($commentaire);
            $manager->flush();
        }
    }

    /**
     * Méthode à implémenter de OrderedFixtureInterface
     */
    public function getOrder(): int
    {
        return 15;
    }
}
