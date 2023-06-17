<?php

namespace App\Controller;

use DateTime;
use App\Entity\BonPlan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/bon-plan', name: 'bonPlan_')]
class BonPlanController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager
    ){}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('bonPlan/index.html.twig', [
            "deals" => $this->manager->getRepository(BonPlan::class)->findAll(),
        ]);
    }

    #[Route('/hot', name: 'hot')]
    public function hot(): Response
    {
        return $this->render('bonPlan/index.html.twig', [
            "deals" => $this->manager->getRepository(BonPlan::class)->getHotBonsPlanTries(),
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $bonPlan = new BonPlan();

        $form = $this->createForm(DealType::class, $bonPlan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $bonPlan->setPostePar($this->getUser());
            $bonPlan->setDatePublication(new DateTime('now'));

            $this->manager->persist($bonPlan);
            $this->manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('bonPlan/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
