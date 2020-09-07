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
        return $this->render('pins/index.html.twig', ['pins'=>$repos->findAll()]);
    }

    /**
     * @Route("/pin/create", name="app_pins_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    { 
        $pin = new Pin;
        $pin->setTitle('Laby Damaro CAMARA');
        $pin->setDescription('Je suis un Data Scientiste en Python');

        $form = $this->createFormBuilder($pin)
             ->add('title', TextType::class, 
             ['label'=>'Titre: ',
             'required'=> true,
              'attr'=>['class'=> 'cool']
              ])
             ->add('description', TextareaType::class, ['label'=>'Descripton: '])
             ->add('submit', SubmitType::class, ['label'=>'Create Pin'])
             ->getForm()
        ;
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()  ) {
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pins/create.html.twig', ['monform' => $form->createView()]);
    }
}
