<?php

namespace App\Controller;

use App\Entity\Deal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    ){}

    #[Route('/', name: 'home')]
    #[Route('/deal/index', name: 'deal_index')]
    public function index(): Response
    {
        return $this->render('deal/index.html.twig', [
            "deals" => $this->manager->getRepository(Deal::class)->findAll(),
        ]);
    }

    #[Route('/deal/hot', name: 'deal_hot')]
    public function hot(): Response
    {
        return $this->render('deal/index.html.twig', [
            "deals" => $this->manager->getRepository(Deal::class)->getHotDealsTries(),
        ]);
    }
}
