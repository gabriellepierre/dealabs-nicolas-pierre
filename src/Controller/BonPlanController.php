<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Form\BonPlanType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/bonplan', name: 'bonPlan_')]
class BonPlanController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager
    ){}



    #[Route('/add', name: 'add')]
    public function index(Request $request): Response
    {
        $deal = new Deal();

        $form = $this->createForm(BonPlanType::class, $deal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $deal->setPostePar($this->getUser());
            $deal->setDatePublication(new DateTime('now'));

            $this->manager->persist($deal);
            $this->manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('bonPlan/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
