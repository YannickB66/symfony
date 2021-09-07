<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KGBController extends AbstractController
{
    #[Route('/kgb', name: 'kgb')]
    public function index(): Response
    {
        return $this->render('kgb/index.html.twig', [
            'controller_name' => 'KGBController',
        ]);
    }
}
