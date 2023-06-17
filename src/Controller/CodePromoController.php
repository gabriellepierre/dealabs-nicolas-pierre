<?php

namespace App\Controller;

use App\Entity\CodePromo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/code-promo', name: 'codePromo_')]
class CodePromoController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager
    ){}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('codePromo/index.html.twig', [
            "deals" => $this->manager->getRepository(CodePromo::class)->findAll(),
        ]);
    }

    
    #[Route('/hot', name: 'hot')]
    public function hot(): Response
    {
        return $this->render('codePromo/index.html.twig', [
            "deals" => $this->manager->getRepository(CodePromo::class)->getHotCodesPromoTries(),
        ]);
    }
}
