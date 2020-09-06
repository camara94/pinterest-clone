<?php

namespace App\Controller;

use App\Entity\Pin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
       $this->em = $em; 
    }

    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $pr = $this->em->getRepository(Pin::class);
        $pins = $pr->findAll();
        return $this->render('pins/index.html.twig', ['pins'=> $pins]);
    }

    public function home()
    {
        return $this->render('pins/home.html.twig');
    }
}
