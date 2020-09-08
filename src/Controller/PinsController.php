<?php

namespace App\Controller;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PinsController extends AbstractController
{

    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(PinRepository $repos): Response
    {
        $repos->createQueryBuilder("delete from pin");
        return $this->render('pins/index.html.twig', ['pins'=>$repos->findAll()]);
    }

    /**
     * @Route("/pin/{id<[0-9]+>}")
     */
    public function shwo(Pin $pin): Response
    {   
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    /**
     * @Route("/pin/create", name="app_pins_create", priority=10, methods={"GET","POST"})
     */
    public function create(Request $request,  EntityManagerInterface $em)
    { 
        $pin = new Pin;
        $pin->setTitle('Laby Damaro CAMARA');
        $pin->setDescription('Je suis un Data Scientiste en Python');

        $form = $this->createFormBuilder($pin)
             ->add('title', null, 
             ['label'=>'Titre: ',
             'required'=> true,
              'attr'=>['class'=> 'cool']
              ])
             ->add('description', null, ['label'=>'Descripton: '])
             ->getForm()
        ;
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()  ) {
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('app_pins_shwo', ['id'=> $pin->getId()]);
        }
        return $this->render('pins/create.html.twig', ['form' => $form->createView()]);
    }
}
