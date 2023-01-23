<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{

    #[Route(path: '/', name: 'homepage')]
    public function homePage()
    {
        return $this->redirectToRoute("app_login");
    }
    #[Route(path: '/home', name: 'home')]
    public function home()
    {
        if ($this->isGranted('ROLE_ADMIN') === true) {
            return $this->redirectToRoute("admin");
        } else if ($this->isGranted('ROLE_CLIENT') === true) {
            return $this->redirectToRoute("client");
        } else if ($this->isGranted('ROLE_LIVREUR') === true) {
            return $this->redirectToRoute("livreur");
        }
    }
}
