<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
   
    /**
     * @Route("/admin", name="app_admin")
     */
    public function afficherusers   (UtilisateurRepository $repository){
        $tableusers=$repository->findAll();
        return $this->render('admin/afficherusers.html.twig'
            ,['tableusers'=>$tableusers]);

    }
}
