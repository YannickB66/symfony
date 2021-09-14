<?php

namespace App\Controller;

use App\Entity\Agent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    #[Route('kgb/mission', name: 'mission')]
    public function index(): Response
    {
        if(!session_id())
        {
            session_start();
            session_regenerate_id();
        }

        $agent = $this->getDoctrine()->getRepository(Agent::class)->findAll();

        return $this->render('kgb/mission/index.html.twig', [
            'controller_name' => 'MissionController',
            'agents' => $agent,
        ]);
    }
}
