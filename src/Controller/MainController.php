<?php

namespace App\Controller;

use App\Entity\Numbers;
use App\Form\NumbersType;
use App\Services\NumbersFactory;
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
     * @param NumbersFactory $numbersFactory
     * @return Response
     */
    public function index(EntityManagerInterface $em, Request $request, NumbersFactory $numbersFactory)
    {
        $numbers = $numbersFactory->createNewNumbers();
        $form = $this->createForm(NumbersType::class, $numbers);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $numbersFactory->saveNumbers();
            $em->persist($numbers);
            $em->flush();
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
