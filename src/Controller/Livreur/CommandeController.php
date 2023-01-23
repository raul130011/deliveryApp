<?php

namespace App\Controller\Livreur;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\LivreurRepository;



#[Route('/livreur/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_livreur_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository, LivreurRepository $livreurRepository,Security $security): Response
    {
        $user = $security->getUser();
        $livreur = $livreurRepository->findOneBy(['user' => $user]);
        return $this->render('LivreurTmp/commande/index.html.twig', [
            'commandes' => $commandeRepository->findBy(['Livreur' => $livreur]),
        ]);
    }

    #[Route('/{id}', name: 'app_livreur_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {

        return $this->render('LivreurTmp/commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }
}
