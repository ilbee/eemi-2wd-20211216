<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $movie = new Movie();
        $form = $this
            ->createFormBuilder($movie)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $movie = $form->getData();
            $em->persist($movie);
            $em->flush();

        }

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'formulaire'        => $form->createView(),
        ]);
    }
}
