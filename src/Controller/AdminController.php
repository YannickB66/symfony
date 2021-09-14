<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Speciality;
use App\Form\AgentType;
use App\Form\SpecialityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('kgb/admin', name: 'admin')]
    public function index(): Response
    {

        if(!session_id())
        {
            session_start();
            session_regenerate_id();
        }

        if(isset($_SESSION['admin']) && $_SESSION['admin'] === 'ok')
        {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'AdminController',
            ]);
        }


        if($_POST)
        {
            if($_POST["email"] === "ybruel@ymail.com")
            {
                if($_POST["password"] === "admin")
                {


                    $_SESSION['admin'] = 'ok';



                    return $this->render('admin/index.html.twig', [
                        'controller_name' => 'AdminController',
                    ]);
                }
            }
        }


        return $this->render('admin/login.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('kgb/admin/speciality', name: 'admin_speciality')]
    public function newSpeciality(Request $request): Response
    {

        $speciality = new Speciality();

        $form = $this->createForm(SpecialityType::class,$speciality);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $speciality = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($speciality);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/speciality.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('kgb/admin/agent', name: 'admin_agent')]
    public function newAgent(Request $request): Response
    {

        $agent = new Agent();

        $form = $this->createForm(AgentType::class,$agent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $agent = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/speciality.html.twig', [
            'controller_name' => 'AdminController',

        ]);
    }



    function verifadmin(): bool|Response
    {
       if(!isset($_SESSION['admin']))
        {
            return $this->render('admin/login.html.twig', [
                'controller_name' => 'AdminController',
            ]);


            }
        if(!$_SESSION['admin'] === 'ok')
        {
            return $this->render('admin/login.html.twig', [
                'controller_name' => 'AdminController',
            ]);

        }


        return false;
    }


}



