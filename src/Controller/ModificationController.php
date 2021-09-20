<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Speciality;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController extends AbstractController
{
    #[Route('kgb/admin/mod_agent', name: 'mod_agent')]
    public function index(): Response
    {
        if(!session_id())
        {
            session_start();
            session_regenerate_id();
        }

        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'ok')
        {
            return $this->redirectToRoute('admin');
        }

        $agents = $this->getDoctrine()->getRepository(Agent::class)->findAll();



        return $this->render('modification/agent.html.twig', [
            'controller_name' => 'ModificationController',
            'agents' => $agents
        ]);
    }

    #[Route('kgb/admin/mod_agent/{id}/{cat}', name: 'agent_mod',requirements: ['page' => '\d+'])]
    public function agentMod(int $id,string $cat): Response
    {
        $specialitys = $this->getDoctrine()->getRepository(Speciality::class)->findAll();
        $agent = $this->getDoctrine()->getRepository(Agent::class)->find($id);

        if($cat === 'name')
        {
            if(isset($_POST['agent']['name']))
            {
                $agent->setName($_POST['agent']['name']);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }
        if($cat === "firstName")
        {
            if(isset($_POST['agent']['firstName']))
            {
                $agent->setFirstName($_POST['agent']['firstName']);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }
        if($cat === "cid")
        {
            if(isset($_POST['agent']['identificationCode']))
            {
                $agent->setIdentificationCode($_POST['agent']['identificationCode']);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }
        if($cat === "nationality")
        {
            if(isset($_POST['agent']['nationality']))
            {
                $agent->setNationality($_POST['agent']['nationality']);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }
        if($cat === "speciality")
        {
            if(isset($_POST['agent']['speciality']))
            {
                foreach ($agent->getSpeciality() as $spe)
                {
                    $agent->removeSpeciality($spe);
                }
                foreach ($_POST['agent']['speciality'] as $spe)
                {
                    $agent->addSpeciality($this->getDoctrine()->getRepository(Speciality::class)->find((int)$spe));
                }

                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }
        if($cat === "birthdate")
        {
            if(isset($_POST['agent']['birthdate']))
            {
                $newDate = DateTime::createFromFormat('Y-m-d', $_POST['agent']['birthdate']);
                $agent->setBirthdate($newDate);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect('/kgb/admin/mod_agent/'.$id);
            }
        }




        return $this->render('modification/agent_mod.html.twig', [
            'controller_name' => 'ModificationController',
            'agent' => $agent,
            'cat' => $cat,
            'specialitys' => $specialitys,
        ]);
    }


    #[Route('kgb/admin/mod_agent/{id}', name: 'agent_detail',requirements: ['page' => '\d+'])]
    public function agentDetail(int $id =1): Response
    {

        $agent = $this->getDoctrine()->getRepository(Agent::class)->find($id);

        return $this->render('modification/agent_detail.html.twig', [
            'controller_name' => 'ModificationController',
            'agent' => $agent,
        ]);
    }

}
