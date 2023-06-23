<?php

namespace App\Controller;

use App\Entity\Deal;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return $this->render('user/account.html.twig', [
            "user" => $this->getUser(),
        ]);
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

    #[Route('/deleteAccount', name: 'deleteAccount')]
    public function deleteAccount(Request $request): Response
    {
        if($request->isXmlHttpRequest()){
            $user = $this->getUser();
            $uuid = Uuid::v4();
            $user->setUsername("PS-" . $uuid)
                ->setEmail("PS-" . $uuid)
                ->setPassword(null)
                ->setPhotoProfil(null)   
                ->setDescription(null)
            ;

            $this->manager->persist($user);
            $this->manager->flush();
            
            return new JsonResponse(['redirect' => $this->generateUrl('security_logout')]);
        }
        return new JsonResponse(['redirect' => $this->generateUrl('user_account')]); 
    }
}
