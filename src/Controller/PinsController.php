<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    private $repos;
    public function __construct(PinRepository $repos)
    {
       $this->repos = $repos; 
    }

    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return $this->render('pins/index.html.twig', ['pins'=>$this->repos->findAll()]);
    }

    public function home()
    {
        return $this->render('pins/home.html.twig');
    }
}
