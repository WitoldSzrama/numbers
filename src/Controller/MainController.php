<?php

namespace App\Controller;

use App\Entity\Numbers;
use App\Form\NumbersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(NumbersType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $numbers = $form->getData();
            $em->persist($numbers);
            $em->flush();
            $this->addFlash('success', 'Wielkosc zbioru: '.$numbers->getInputNumber().' maksymalna wartosc w zbiorze: '.$numbers->getResult());

            return $this->redirectToRoute('main');
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function numbersList()
    {
        $allNumbers = $this->getDoctrine()->getRepository(Numbers::class)->findAllDesc();

        return $this->render('main/numbersList.html.twig', ['allNumbers' => $allNumbers]);
    }
}
