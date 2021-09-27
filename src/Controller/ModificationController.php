<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Speciality;
use App\Entity\Target;
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

    #[Route('kgb/admin/mod_agent/{id}/{cat}', name: 'agent_mod',requirements: ['id' => '\d+'])]
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


    #[Route('kgb/admin/mod_agent/{id}', name: 'agent_detail',requirements: ['id' => '\d+'])]
    public function agentDetail(int $id =1): Response
    {

        $agent = $this->getDoctrine()->getRepository(Agent::class)->find($id);

        return $this->render('modification/agent_detail.html.twig', [
            'controller_name' => 'ModificationController',
            'agent' => $agent,
        ]);
    }



    #[Route('kgb/admin/mod_speciality', name: 'mod_speciality')]
    public function modSpeciality(): Response
    {
        $specialitys = $this->getDoctrine()->getRepository(Speciality::class)->findAll();
        $item ="";

        if($_GET)
        {
            $item = $_GET['id'];
        }

        if($_POST)
        {
            $speciality = $this->getDoctrine()->getRepository(Speciality::class)->find($_POST['speciality']['id']);
            $speciality->setName($_POST['speciality']['name']);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mod_speciality');
        }

        return $this->render('modification/speciality.html.twig', [
            'controller_name' => 'ModificationController',
            'specialitys' => $specialitys,
            'item' => $item,
        ]);
    }

    #[Route('kgb/admin/mod_hideout', name: 'mod_hideout')]
    public function modHideout(): Response
    {
        $hideouts = $this->getDoctrine()->getRepository(Hideout::class)->findAll();
        $field ="";
        $item = "";

        if($_GET)
        {
            $field = $_GET['field'];
            $item = $_GET['item'];
        }

        if($_POST)
        {
            $speciality = $this->getDoctrine()->getRepository(Hideout::class)->find($_POST['hideout']['id']);
            if(isset($_POST['hideout']['code']))
            {
                $speciality->setCode($_POST['hideout']['code']);
            }
            if(isset($_POST['hideout']['adress']))
            {
                $speciality->setAdress($_POST['hideout']['adress']);
            }
            if(isset($_POST['hideout']['country']))
            {
                $speciality->setCountry($_POST['hideout']['country']);
            }
            if(isset($_POST['hideout']['type']))
            {
                $speciality->setType($_POST['hideout']['type']);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mod_hideout');
        }


        return $this->render('modification/hideout.html.twig', [
            'controller_name' => 'ModificationController',
            'hideouts' => $hideouts,
            'field' => $field,
            'item' => $item,
        ]);
    }

    #[Route('kgb/admin/mod_contact', name: 'mod_contact')]
    public function modContact(): Response
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $field ="";
        $item = "";

        if($_GET)
        {
            $field = $_GET['field'];
            $item = $_GET['item'];
        }

        if($_POST)
        {
            $contact = $this->getDoctrine()->getRepository(Contact::class)->find($_POST['contact']['id']);
            if(isset($_POST['contact']['codename']))
            {
                $contact->setCodename($_POST['contact']['codename']);
            }
            if(isset($_POST['contact']['name']))
            {
                $contact->setName($_POST['contact']['name']);
            }
            if(isset($_POST['contact']['firstName']))
            {
                $contact->setFirstName($_POST['contact']['firstName']);
            }
            if(isset($_POST['contact']['birthdate']))
            {
                $newDate = DateTime::createFromFormat('Y-m-d', $_POST['contact']['birthdate']);
                $contact->setBirthdate($newDate);
            }
            if(isset($_POST['contact']['nationality']))
            {
                $contact->setNationality($_POST['contact']['nationality']);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mod_contact');
        }

        return $this->render('modification/contact.html.twig', [
            'controller_name' => 'ModificationController',
            'contacts' => $contacts,
            'field' => $field,
            'item' => $item,
        ]);
    }

    #[Route('kgb/admin/mod_target', name: 'mod_target')]
    public function modTarget(): Response
    {
        $targets = $this->getDoctrine()->getRepository(Target::class)->findAll();
        $field ="";
        $item = "";

        if($_GET)
        {
            $field = $_GET['field'];
            $item = $_GET['item'];
        }

        if($_POST)
        {
            $target = $this->getDoctrine()->getRepository(Target::class)->find($_POST['target']['id']);
            if(isset($_POST['target']['codename']))
            {
                $target->setCodename($_POST['target']['codename']);
            }
            if(isset($_POST['target']['name']))
            {
                $target->setName($_POST['target']['name']);
            }
            if(isset($_POST['target']['firstName']))
            {
                $target->setFirstName($_POST['target']['firstName']);
            }
            if(isset($_POST['target']['birthdate']))
            {
                $newDate = DateTime::createFromFormat('Y-m-d', $_POST['target']['birthdate']);
                $target->setBirthdate($newDate);
            }
            if(isset($_POST['target']['nationality']))
            {
                $target->setNationality($_POST['target']['nationality']);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mod_target');
        }

        return $this->render('modification/target.html.twig', [
            'controller_name' => 'ModificationController',
            'targets' => $targets,
            'field' => $field,
            'item' => $item,
        ]);
    }

    #[Route('kgb/admin/mod_mission', name: 'mod_mission')]
    public function modMission(): Response
    {
        $missions = $this->getDoctrine()->getRepository(Mission::class)->findAll();


        return $this->render('modification/mission.html.twig', [
            'controller_name' => 'ModificationController',
            'missions' => $missions,
        ]);
    }

    #[Route('kgb/admin/mod_mission/{id}', name: 'mod_mission_detail', requirements: ['id' => '\d+'])]
    public function modMissionDetail($id): Response
    {
        $mission = $this->getDoctrine()->getRepository(Mission::class)->find($id);
        $specialitys = $this->getDoctrine()->getRepository(Speciality::class)->findAll();
        $agents = $this->getDoctrine()->getRepository(Agent::class)->findAll();
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $hideouts = $this->getDoctrine()->getRepository(Hideout::class)->findAll();
        $targets = $this->getDoctrine()->getRepository(Target::class)->findAll();

        $field ="";

        if($_GET)
        {
            $field = $_GET['field'];
        }

        if($_POST)
        {
            if(isset($_POST['mission']['title']))
            {
                $mission->setTitle($_POST['mission']['title']);
            }
            if(isset($_POST['mission']['description']))
            {
                $mission->setDescription($_POST['mission']['description']);
            }
            if(isset($_POST['mission']['codename']))
            {
                $mission->setCodename($_POST['mission']['codename']);
            }
            if(isset($_POST['mission']['statut']))
            {
                $mission->setStatut($_POST['mission']['statut']);
            }
            if(isset($_POST['mission']['dateStart']))
            {
                $newDate = DateTime::createFromFormat('Y-m-d', $_POST['mission']['dateStart']);
                $mission->setDateStart($newDate);
            }
            if(isset($_POST['mission']['dateEnd']))
            {
                $newDate = DateTime::createFromFormat('Y-m-d', $_POST['mission']['dateEnd']);
                $mission->setDateEnd($newDate);
            }
            if(isset($_POST['mission']['requireSpeciality']))
            {
                $spe = $this->getDoctrine()->getRepository(Speciality::class)->find((int)$_POST['mission']['requireSpeciality']);
                $mission->setRequireSpeciality($spe);
            }
            if(isset($_POST['mission']['agent']))
            {
                foreach ($mission->getAgent() as $agentTemp)
                {
                    $mission->removeAgent($agentTemp);
                }
                foreach ($_POST['mission']['agent'] as $idTemp)
                {
                    $mission->addAgent($this->getDoctrine()->getRepository(Agent::class)->find($idTemp));
                }
            }
            if(isset($_POST['mission']['contact']))
            {
                foreach ($mission->getContact() as $contactTemp)
                {
                    $mission->removeAgent($contactTemp);
                }
                foreach ($_POST['mission']['contact'] as $idTemp)
                {
                    $mission->addContact($this->getDoctrine()->getRepository(Contact::class)->find($idTemp));
                }
            }
            if(isset($_POST['mission']['target']))
            {
                foreach ($mission->getContact() as $targetTemp)
                {
                    $mission->removeAgent($targetTemp);
                }
                foreach ($_POST['mission']['target'] as $idTemp)
                {
                    $mission->addTarget($this->getDoctrine()->getRepository(Target::class)->find($idTemp));
                }
            }


            $this->getDoctrine()->getManager()->flush();

        }

        return $this->render('modification/mission_detail.html.twig', [
            'controller_name' => 'ModificationController',
            'mission' => $mission,
            'field' => $field,
            'specialitys' => $specialitys,
            'agents' => $agents,
            'contacts' => $contacts,
            'hideouts' => $hideouts,
            'targets' => $targets,
        ]);
    }


}
