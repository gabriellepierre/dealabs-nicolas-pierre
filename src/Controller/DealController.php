<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\User;
use App\Entity\UserDealInteraction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/deal/like/{idDeal}', name: 'deal_like')]
    public function like(Request $request, int $idDeal): Response
    {
        return $this->manageLiked($request, $idDeal, 1);
    }

    #[Route('/deal/dislike/{idDeal}', name: 'deal_dislike')]
    public function dislike(Request $request, int $idDeal): Response
    {
        return $this->manageLiked($request, $idDeal, -1);
    }

    private function manageLiked(Request $request, int $idDeal, int $value): Response
    {
        $user = $this->getUser();
        //Check si l'utilisateur c'est connecté
        if($user != null){
            $deal = $this->manager->getRepository(Deal::class)->find($idDeal);

            //Check si l'utilisateur n'a pas déjà liké ou disliké
            $interaction = $this->manager->getRepository(UserDealInteraction::class)->findOneBy(["user" => $user, "deal" => $deal]);
            if($interaction->getLiked() != $value){
                //Si l'utilisateur n'a toujours pas intéragi avec ce deal
                if($interaction == null){
                    $interaction = new UserDealInteraction($user,$deal);
                    $this->manager->persist($interaction);
                }
                //Si l'utilisateur avait déjà intéragi avec ce deal MAIS que la valeur n'est pas la même qu'enregistrée
                $interaction->setLiked($value); 
            } else{
                //Si l'utilisateur avait déjà intéragi avec ce deal MAIS que la valeur est la même qu'enregistrée 
                $interaction->setLiked(0);
            }
            $this->manager->flush();
            return $this->redirect($request->headers->get("referer"));
        }
        return $this->redirectToRoute('security_login'); 
    }
}
