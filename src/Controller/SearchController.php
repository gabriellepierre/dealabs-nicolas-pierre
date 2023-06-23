<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DealRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route("/search/{type}", name: "search_deal")]  
    public function searchDeal(Request $request, string $type, DealRepository $dealRepository, UserRepository $userRepository)
    {
            $term = $request->request->get('term');
            // $request->query->get('term');

            $deals = $dealRepository->findByTitleOrDescription($term);
            $users = $userRepository->findByUsername($term);
            $countDeals = count($deals);
            $countUsers = count($users);

            if($type == 'deal') {
                return $this->render('search/index.html.twig', [
                    'term' => $term,
                    'results' => $deals,
                    'count' => $countDeals
                ]);

            } else if($type == 'user') {
                return $this->render('search/user.html.twig', [
                    'term' => $term,
                    'results' => $users,
                    'count' => $countUsers
                ]);
            }
    }
}