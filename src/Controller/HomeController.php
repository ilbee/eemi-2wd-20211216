<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $movie = new Movie();
        $movie->setName('The Matrix');

        $em->persist($movie);
        $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'movie'             => $movie,
        ]);
    }
}
