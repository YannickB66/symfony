<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('kgb/admin', name: 'admin')]
    public function index(): Response
    {


        if(isset($_SESSION["admin"]))
        {
         if($_SESSION["admin"]== 'ok')
         {
             return $this->render('admin/index2.html.twig', [
                 'controller_name' => 'AdminController',
             ]);
         }
        }

        if($_POST)
        {
            if($_POST["email"] === "ybruel@ymail.com")
            {
                if($_POST["password"] === "admin")
                {

                    if(!session_id())
                    {
                        session_start();
                        session_regenerate_id();
                        $_SESSION['admin'] = 'ok';
                    }


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
}
