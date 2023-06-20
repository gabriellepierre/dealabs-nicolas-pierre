<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\UserDealInteraction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager
    ){}

    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        return $this->render('user/account.html.twig');
    }

    #[Route('/deals', name: 'deals')]
    public function deals(): Response
    {
        $user = $this->getUser();
        return $this->render('user/deals.html.twig', [
            "deals" => $this->manager->getRepository(Deal::class)->findBy(["postePar" => $user]),
        ]);
    }

    #[Route('/deals-saved', name: 'dealsSaved')]
    public function dealsSaved(): Response
    {
        $user = $this->getUser();
        return $this->render('user/deals-saved.html.twig', [
            "deals" => $user->getDealsSaved(),
        ]);
    }

    #[Route('/alerts', name: 'alerts')]
    public function alerts(): Response
    {
        return $this->render('user/alerts.html.twig');
    }
}
