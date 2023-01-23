<?php

namespace App\Controller\Livreur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route(path: '/livreur', name: 'livreur')]
    public function home()
    {
        
        return $this->render('security/home.html.twig',[]);
    }
}
