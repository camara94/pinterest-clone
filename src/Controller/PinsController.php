<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PinsController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $repos): Response
    {
        return $this->render('pins/index.html.twig', ['pins'=>$repos->findAll()]);
    }

    /**
     * @Route("/pin/create", name="app_pins_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    { 
        if( $request->isMethod('POST')  ) {
            $data = $request->request->all();
            if ( $this->isCsrfTokenValid('pin_create', $data['_token'])  ) {
                $pin = new Pin;
                $pin->setTitle($data['title']);
                $pin->setDescription($data['description']);
                $em->persist($pin);
                $em->flush();
            }
            //return $this->redirect($this->generateUrl('app_home')); ou
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pins/create.html.twig');
    }
}
