<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Speciality;
use App\Entity\Target;
use App\Form\ContactType;
use App\Form\HideoutType;
use App\Form\MissionType;
use App\Form\SpecialityType;
use App\Form\TargetType;
use DateTime;
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

        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

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
            'entity' => 'spécialité',
            'form' => $form->createView(),
        ]);
    }

    #[Route('kgb/admin/agent', name: 'admin_agent')]
    public function newAgent(Request $request): Response
    {
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        if(isset($_POST['agent']))
        {
            $agentD = $_POST['agent'];
            $agent = new Agent();

            $agent->setIdentificationCode($agentD['identificationCode']);
            $agent->setName($agentD['name']);
            $agent->setFirstName($agentD['firstName']);

            $bd = $agentD['birthdate']['year'].'-'.$agentD['birthdate']['month'].'-'.$agentD['birthdate']['day'];
            $birthdate = DateTime::createFromFormat('Y-m-d', $bd);
            $agent->setBirthdate($birthdate);

            $agent->setNationality($agentD['nationality']);

            foreach ($agentD['speciality'] as $sp)
            {
                $agent->addSpeciality($this->getDoctrine()->getRepository(Speciality::class)->find((int)$sp));
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        $specialitys = $this->getDoctrine()->getRepository(Speciality::class)->findAll();


        return $this->render('admin/agent.html.twig', [
            'controller_name' => 'AdminController',
            'entity' => 'agent',
            'specialitys' => $specialitys,

        ]);
    }

    #[Route('kgb/admin/contact', name: 'admin_contact')]
    public function newContact(Request $request): Response
    {
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        $contact = new Contact();

        $form = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/speciality.html.twig', [
            'controller_name' => 'AdminController',
            'entity' => 'contact',
            'form' => $form->createView(),

        ]);
    }

    #[Route('kgb/admin/target', name: 'admin_target')]
    public function newTarget(Request $request): Response
    {
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        $target = new Target();

        $form = $this->createForm(TargetType::class,$target);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $target = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($target);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/speciality.html.twig', [
            'controller_name' => 'AdminController',
            'entity' => 'cible',
            'form' => $form->createView(),

        ]);
    }

    #[Route('kgb/admin/hideout', name: 'admin_target')]
    public function newHideout(Request $request): Response
    {
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        $hideout = new Hideout();

        $form = $this->createForm(HideoutType::class,$hideout);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hideout = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hideout);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/speciality.html.twig', [
            'controller_name' => 'AdminController',
            'entity' => 'planque',
            'form' => $form->createView(),

        ]);
    }

    #[Route('kgb/admin/mission', name: 'admin_mission')]
    public function newMission(Request $request): Response
    {
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        if(isset($_POST['mission']))
        {
            $missionD = $_POST['mission'];

            var_dump($missionD);

            $mission = new Mission();

            $mission->setTitle($missionD['title']);
            $mission->setDescription($missionD['description']);
            $mission->setCodename($missionD['codename']);
            $mission->setStatut($missionD['statut']);
            $mission->setType($missionD['type']);


            $dt = $missionD['dateStart']['year'].'-'.$missionD['dateStart']['month'].'-'.$missionD['dateStart']['day'];
            $dtf = DateTime::createFromFormat('Y-m-d', $dt);
            $mission->setDateStart($dtf);
            $dt = $missionD['dateEnd']['year'].'-'.$missionD['dateEnd']['month'].'-'.$missionD['dateEnd']['day'];
            $dtf = DateTime::createFromFormat('Y-m-d', $dt);
            $mission->setDateEnd($dtf);

            $mission->setCountry($missionD['country']);


            foreach ($missionD['agent'] as $temp)
            {
                $mission->addAgent($this->getDoctrine()->getRepository(Agent::class)->find((int)$temp));
            }

            $mission->setRequireSpeciality($this->getDoctrine()->getRepository(Speciality::class)->find($missionD['requireSpeciality']));

            foreach ($missionD['hideout'] as $temp)
            {
                $mission->addHideout($this->getDoctrine()->getRepository(Hideout::class)->find((int)$temp));
            }

            foreach ($missionD['contact'] as $temp)
            {
                $mission->addContact($this->getDoctrine()->getRepository(Contact::class)->find((int)$temp));
            }

            foreach ($missionD['target'] as $temp)
            {
                $mission->addTarget($this->getDoctrine()->getRepository(Target::class)->find((int)$temp));
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }


        $agents = $this->getDoctrine()->getRepository(Agent::class)->findAll();
        $specialitys = $this->getDoctrine()->getRepository(Speciality::class)->findAll();
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $hideouts = $this->getDoctrine()->getRepository(Hideout::class)->findAll();
        $targets = $this->getDoctrine()->getRepository(Target::class)->findAll();


        return $this->render('admin/mission.html.twig', [
            'controller_name' => 'AdminController',
            'entity' => 'mission',
            'agents' => $agents,
            'specialitys' => $specialitys,
            'contacts' => $contacts,
            'hideouts' => $hideouts,
            'targets' => $targets,
        ]);
    }





}