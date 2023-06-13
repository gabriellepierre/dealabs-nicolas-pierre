<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        return $this->render('user/account.html.twig');
    }

    #[Route('/deals', name: 'deals')]
    public function deals(): Response
    {
        return $this->render('user/deals.html.twig');
    }

    #[Route('/deals-saved', name: 'dealsSaved')]
    public function dealsSaved(): Response
    {
        return $this->render('user/deals-saved.html.twig');
    }

    #[Route('/alerts', name: 'alerts')]
    public function alerts(): Response
    {
        return $this->render('user/alerts.html.twig');
    }
}
