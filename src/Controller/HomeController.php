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
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('home/accueil.html.twig');
    }

    /**
     * @Route("/creation-dun-film", name="home")
     */
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $movie = new Movie();
        $formBuilder = $this->createFormBuilder($movie);
        $formBuilder->add('name', TextType::class);
        $formBuilder->add('save', SubmitType::class, ['label' => 'Add movie']);

        $form = $formBuilder->getForm();
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
