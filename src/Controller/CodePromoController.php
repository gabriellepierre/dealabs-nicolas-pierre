<?php

namespace App\Controller;

use DateTime;
use App\Entity\CodePromo;
use App\Form\CodePromoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $codePromo = new CodePromo();

        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $codePromo->setPostePar($this->getUser());
            $codePromo->setDatePublication(new DateTime('now'));

            $this->manager->persist($codePromo);
            $this->manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('deal/form_add.html.twig', [
            'form' => $form->createView(),
            'entityName' => "code promo",
        ]);
    }
}
